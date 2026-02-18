# Plan du projet Laravel — Système d'activités avec points

---

## Vue d'ensemble du projet

L'application permet à des utilisateurs de **s'inscrire, se connecter** et **choisir des activités** qui ont un coût en points. Chaque utilisateur possède un solde de points (portefeuille) qui diminue lorsqu'il s'inscrit à une activité, et est remboursé s'il se désinscrit.

---

## Architecture générale

```
Utilisateur
│
├── S'inscrit / Se connecte (Auth)
├── Consulte la liste des activités
├── S'inscrit à une activité (si assez de points et places disponibles)
│     └── Son solde diminue du coût de l'activité
└── Se désinscrit d'une activité
      └── Son solde est remboursé
```

### Tables en base de données

| Table | Rôle |
|---|---|
| `users` | Données utilisateur + solde de points |
| `activities` | Liste des activités + coût en points |
| `activity_user` | Table pivot — qui est inscrit à quoi |

### Relations entre modèles

- Un `User` **appartient à plusieurs** `Activity` (via la table pivot)
- Une `Activity` **a plusieurs** `User` (via la table pivot)

---

## Plan complet des fonctionnalités

### 1. Authentification
- Inscription (nom, email, mot de passe)
- Connexion / Déconnexion
- Profil utilisateur (modification, suppression du compte)

### 2. Gestion des activités
- Lister toutes les activités (triées par date)
- Voir les places restantes pour chaque activité
- Savoir si l'utilisateur est déjà inscrit

### 3. Système de points (portefeuille)
- Chaque utilisateur a un solde de points à la création de son compte
- Chaque activité a un coût en points
- L'inscription à une activité déduit les points du solde
- La désinscription rembourse les points
- Refus d'inscription si solde insuffisant
- Affichage du solde dans l'interface

### 4. Inscription / Désinscription aux activités
- Vérification : l'utilisateur n'est pas déjà inscrit
- Vérification : l'activité n'est pas complète
- Vérification : l'utilisateur a assez de points
- Inscription et déduction atomique (transaction DB)
- Désinscription et remboursement

---

## État d'avancement

### ✅ Déjà fait

#### Base de données
- [x] Migration `users` — table de base avec nom, email, mot de passe
- [x] Migration `activities` — titre, description, date, heure, max participants
- [x] Migration `activity_user` — table pivot avec contrainte d'unicité (pas de double inscription)
- [x] Migration `cache`, `jobs`, `sessions` — tables système Laravel

#### Modèles
- [x] `User.php` — relation `belongsToMany(Activity::class)` définie
- [x] `Activity.php` — relation `belongsToMany(User::class)` définie
- [x] `Activity.php` — méthodes utilitaires : `isFull()`, `availableSpots()`, `hasUser()`

#### Contrôleurs
- [x] `ActivityController@index` — liste toutes les activités triées par date
- [x] `ActivityController@register` — inscription avec vérifications (déjà inscrit, activité pleine)
- [x] `ActivityController@unregister` — désinscription
- [x] `ProfileController` — modification et suppression du profil

#### Routes
- [x] Route `/activities` — liste des activités (protégée `auth`)
- [x] Route `/activities/{activity}/register` — inscription (protégée `auth`)
- [x] Route `/activities/{activity}/unregister` — désinscription (protégée `auth`)
- [x] Routes du profil — edit, update, destroy
- [x] Routes d'auth — via `auth.php` (Breeze)

#### Auth
- [x] Laravel Breeze installé — inscription, connexion, déconnexion fonctionnelles

---

### 🔧 Reste à faire

#### 1. Ajouter les points à la base de données

**Nouvelle migration — colonne `points` sur `users`**
```bash
php artisan make:migration add_points_to_users_table --table=users
```
```php
$table->integer('points')->default(100); // Solde de départ à définir
```

**Nouvelle migration — colonne `points_cost` sur `activities`**
```bash
php artisan make:migration add_points_cost_to_activities_table --table=activities
```
```php
$table->integer('points_cost')->default(0);
```

---

#### 2. Mettre à jour les modèles

**`User.php`** — ajouter `points` dans `$fillable` :
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'points', // ← ajouter
];
```

**`Activity.php`** — ajouter `points_cost` dans `$fillable` :
```php
protected $fillable = [
    'title',
    'description',
    'activity_date',
    'activity_time',
    'max_participants',
    'points_cost', // ← ajouter
];
```

---

#### 3. Modifier `ActivityController@register`

Ajouter la vérification du solde et la déduction des points, dans une transaction pour garantir l'intégrité des données :

```php
use Illuminate\Support\Facades\DB;

public function register(Activity $activity)
{
    $user = Auth::user();

    // Vérification déjà inscrit
    if ($activity->hasUser($user->id)) {
        return redirect()->back()->with('error', 'Vous êtes déjà inscrit à cette activité.');
    }

    // Vérification places disponibles
    if ($activity->isFull()) {
        return redirect()->back()->with('error', 'Cette activité est complète.');
    }

    // Vérification solde suffisant ← NOUVEAU
    if ($user->points < $activity->points_cost) {
        return redirect()->back()->with('error', 'Vous n\'avez pas assez de points.');
    }

    // Inscription + déduction atomique ← NOUVEAU
    DB::transaction(function () use ($activity, $user) {
        $activity->users()->attach($user->id);
        $user->decrement('points', $activity->points_cost);
    });

    return redirect()->back()->with('success', 'Inscription confirmée !');
}
```

---

#### 4. Modifier `ActivityController@unregister`

Rembourser les points à la désinscription :

```php
public function unregister(Activity $activity)
{
    $user = Auth::user();

    DB::transaction(function () use ($activity, $user) {
        $activity->users()->detach($user->id);
        $user->increment('points', $activity->points_cost); // ← NOUVEAU
    });

    return redirect()->back()->with('success', 'Désinscription confirmée. Points remboursés.');
}
```

---

#### 5. Afficher le solde dans les vues

Dans le layout principal (ex: `resources/views/layouts/app.blade.php`), ajouter l'affichage du solde :

```blade
@auth
    <span>Mon solde : {{ Auth::user()->points }} pts</span>
@endauth
```

Dans la vue `activities/index.blade.php`, afficher le coût de chaque activité :

```blade
<p>Coût : {{ $activity->points_cost }} points</p>
```

---

#### 6. Définir le solde de départ à l'inscription (optionnel mais recommandé)

Par défaut la migration donne 100 points, mais si tu veux personnaliser selon le rôle ou un formulaire d'inscription, il faudra le gérer dans le contrôleur d'auth ou via un événement `Registered`.

---

## Récapitulatif du temps restant

| Tâche | 
|---|
| 2 nouvelles migrations |
| Mise à jour des modèles | 
| `register()` avec points |
| `unregister()` avec remboursement | 
| Affichage du solde dans les vues | 
| Tests manuels |

---

## Ordre recommandé pour finir le projet

1. Créer les deux migrations et lancer `php artisan migrate`
2. Mettre à jour les `$fillable` des modèles
3. Modifier `ActivityController@register` avec la logique de points
4. Modifier `ActivityController@unregister` avec le remboursement
5. Afficher le solde dans les vues
6. Tester manuellement (inscription, solde insuffisant, désinscription, remboursement)