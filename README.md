# Welcome to Api POSTINGAN!

API POSTINGAN adalah sebuah REST API (Representational State Transfer Application Programming Interface) untuk mengelola postingan yang dibuat oleh setiap pengguna.


# Teknologi

 - Laravel
 - MySQL
 - Composer
 - JWT


## ER diagrams
```mermaid
erDiagram

User  ||--o{  Postingan  : "kagegori"

Kategori  ||--o{  Postingan  : "kagegori"
