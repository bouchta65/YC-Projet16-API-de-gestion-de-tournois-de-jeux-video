# Laravel Tournament API

## Contexte du projet

Ce projet est une API RESTful développée avec Laravel, permettant la gestion des tournois, l'inscription des joueurs et l'organisation des matchs avec suivi des scores.

---

## 2. Endpoints de l'API

### 2.1. Authentification (JWT)

| Méthode | Endpoint      | Description |
|---------|--------------|-------------|
| `POST`  | `/api/register` | Inscription d'un nouvel utilisateur. |
| `POST`  | `/api/login` | Connexion et obtention d'un token d'accès. |
| `POST`  | `/api/logout` | Déconnexion et invalidation du token d'accès. |
| `GET`   | `/api/user` | Récupération des informations de l'utilisateur authentifié. |

---

### 2.2. Gestion des Tournois

| Méthode | Endpoint      | Description |
|---------|--------------|-------------|
| `POST`  | `/api/tournaments` | Création d'un nouveau tournoi. |
| `GET`   | `/api/tournaments` | Liste de tous les tournois existants. |
| `GET`   | `/api/tournaments/{id}` | Affichage des détails d'un tournoi spécifique. |
| `PUT`   | `/api/tournaments/{id}` | Modification des informations d'un tournoi. |
| `DELETE` | `/api/tournaments/{id}` | Suppression d'un tournoi. |

---

### 2.3. Inscription des Joueurs

| Méthode | Endpoint      | Description |
|---------|--------------|-------------|
| `POST`  | `/api/tournaments/{tournament_id}/players` | Inscription d'un joueur à un tournoi donné. |
| `GET`   | `/api/tournaments/{tournament_id}/players` | Liste de tous les joueurs inscrits à un tournoi. |
| `DELETE` | `/api/tournaments/{tournament_id}/players/{player_id}` | Désinscription d'un joueur du tournoi. |

---

### 2.4. Gestion des Matchs et des Scores

| Méthode | Endpoint      | Description |
|---------|--------------|-------------|
| `POST`  | `/api/matches` | Création d'un match en associant un tournoi et les joueurs participants. |
| `GET`   | `/api/matches` | Liste de tous les matchs programmés. |
| `GET`   | `/api/matches/{id}` | Affichage des détails d'un match (incluant les scores, participants, etc.). |
| `PUT`   | `/api/matches/{id}` | Mise à jour des informations d'un match, notamment pour ajouter ou modifier les scores. |
| `DELETE` | `/api/matches/{id}` | Suppression d'un match. |
| `POST`  | `/api/matches/{id}/scores` | Ajout de scores spécifiques à un match. |
| `PUT`   | `/api/matches/{id}/scores` | Mise à jour des scores pour un match donné. |

---

## 3. Contraintes et exigences

### 3.1. Respect des conventions RESTful

- Utilisation des méthodes HTTP adaptées (`GET`, `POST`, `PUT`, `DELETE`).
- Structuration claire et versionnée des endpoints pour faciliter la maintenance et l'évolution de l'API.

### 3.2. Sécurité

- Authentification sécurisée via JWT.
- Protection des endpoints sensibles grâce au middleware `auth:JWT`.
- Validation stricte des données d'entrée pour prévenir les injections SQL, XSS et autres attaques.

### 3.3. Tests et Qualité (TDD)

- **Approche TDD** :  
  - Avant de développer une fonctionnalité, des tests unitaires et/ou d'intégration doivent être écrits pour définir les comportements attendus.
  - Utilisation de PHPUnit ou Pest pour implémenter les tests.
  - Chaque endpoint (contrôleurs, modèles et services) doit être couvert par des tests pour valider le comportement et la robustesse du code.
  - Intégration dans un pipeline CI/CD pour automatiser l'exécution des tests à chaque commit.

### 3.4. Documentation

- Documentation détaillée des endpoints via **Postman** ou **Swagger**.
- Fourniture d'exemples de requêtes et de réponses JSON pour faciliter l'intégration par des développeurs tiers.
