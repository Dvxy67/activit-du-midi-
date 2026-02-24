# Ce qu'il reste à faire — Projet Laravel Activités

---

## Déjà terminé

- [x] Authentification (inscription, connexion, déconnexion) via Breeze
- [x] Migrations (users, activities, activity_user, points, points_cost)
- [x] Modèles User et Activity avec relations et méthodes utilitaires
- [x] ActivityController — liste, inscription, désinscription
- [x] Système de points — déduction à l'inscription, remboursement à la désinscription
- [x] Transactions DB pour garantir l'intégrité des données
- [x] Seeder — 3 activités de test + utilisateur de test
- [x] Vue des activités avec design raffiné
- [x] Affichage du solde de points dans la navigation et la page activités
- [x] Repo GitHub mis en place

---

## Reste à faire

### 1. Système de rôles Admin
- [ ] Nouvelle migration — ajouter colonne `is_admin` (boolean) sur la table `users`
- [ ] Mettre à jour le modèle `User` — ajouter `is_admin` dans `$fillable`
- [ ] Créer un middleware `IsAdmin` pour protéger les routes admin
- [ ] Enregistrer le middleware dans `bootstrap/app.php`

---

### 2. CRUD des activités (côté Admin)
- [ ] Créer les routes admin dans `web.php`
- [ ] Créer un `AdminActivityController` avec les méthodes :
  - `index()` — liste toutes les activités
  - `create()` — formulaire de création
  - `store()` — enregistrer une nouvelle activité
  - `edit()` — formulaire de modification
  - `update()` — sauvegarder les modifications
  - `destroy()` — supprimer une activité
- [ ] Créer les vues admin :
  - `admin/activities/index.blade.php`
  - `admin/activities/create.blade.php`
  - `admin/activities/edit.blade.php`

---

### 3. Gestion des utilisateurs (côté Admin)
- [ ] Créer un `AdminUserController` pour que l'admin puisse :
  - Voir la liste des utilisateurs et leur solde
  - Modifier le solde de points d'un utilisateur
  - Passer un utilisateur en admin

---

### 4. Améliorations optionnelles
- [ ] Page de profil — afficher les activités auxquelles l'utilisateur est inscrit
- [ ] Empêcher l'inscription à une activité passée (vérification de la date)
- [ ] Ajouter une image ou une catégorie aux activités
- [ ] Pagination si beaucoup d'activités

---

## Ordre recommandé

1. Migration + middleware `is_admin`
2. Routes et `AdminActivityController`
3. Vues admin (create, edit, index)
4. Gestion des utilisateurs côté admin
5. Améliorations optionnelles