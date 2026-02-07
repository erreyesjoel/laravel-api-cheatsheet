# Seeders Interactivos
- Que se entiende o que son los seeders interactivos?
**Son seeders que se ejecutan de forma interactiva, es decir, que nos permiten interactuar con ellos a traves de la terminal**
- Haremos un ejemplo para crear tareas de forma interactiva
- Pero primero de todo, veremos cuantos usuarios tenemos en nuestra base de datos
```sql
+----+-----------------+--------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
| id | name            | email              | email_verified_at | password                                                     | remember_token | created_at          | updated_at          |
+----+-----------------+--------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
|  1 | Joel Erreyes    | joel@erreyes.com   | NULL              | $2y$12$bqyfXJwL0zkRYgzUR8wTPeRasKQKMlnzqcsAcIC4M671hmrlynaOO | NULL           | 2026-02-07 22:48:19 | 2026-02-07 22:48:19 |
|  2 | Joel Erreyes 2  | joel2@erreyes.com  | NULL              | $2y$12$ubwDxqCtUNf1fygUd6bFC.FhcYT.kMmaxsYebl8rzNxjfmEbxY8aa | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  3 | Joel Erreyes 3  | joel3@erreyes.com  | NULL              | $2y$12$Wx8THlr4bN5Sbnf2cQU2gO4g0nr2m53Qxcb0OL/usvgnOIE1mZ7ma | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  4 | Joel Erreyes 4  | joel4@erreyes.com  | NULL              | $2y$12$s/ZNr1ba9AYtJIUHqqZdsuvKGs3i4whKopfrRa3QzNYgsJL3wZR1m | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  5 | Joel Erreyes 5  | joel5@erreyes.com  | NULL              | $2y$12$mqhybViu9z6Vh95BU7iOJ.KpiRP.sRsLziEKZYL4qKw06PXriveHe | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  6 | Joel Erreyes 6  | joel6@erreyes.com  | NULL              | $2y$12$NK.lnm630TtcE2hbqLWfNe1etlWijs0zhllwUtJwB84EQM/g5azby | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  7 | Joel Erreyes 7  | joel7@erreyes.com  | NULL              | $2y$12$5l7ltkz8u7jpraec2UhLE.D/UQNg/pA5KC5uSAg88bYJisiAkxK1G | NULL           | 2026-02-07 22:48:20 | 2026-02-07 22:48:20 |
|  8 | Joel Erreyes 8  | joel8@erreyes.com  | NULL              | $2y$12$5ODWxQycR0zcB6hQk/JKluJiSACGYpleKZttFcr1GsspOf31diuEq | NULL           | 2026-02-07 22:48:21 | 2026-02-07 22:48:21 |
|  9 | Joel Erreyes 9  | joel9@erreyes.com  | NULL              | $2y$12$c8tBtGe9cCSKaxjMkohLFej92OL47U15JWxA6JtuX9GcNoS3vufMi | NULL           | 2026-02-07 22:48:21 | 2026-02-07 22:48:21 |
| 10 | Joel Erreyes 10 | joel10@erreyes.com | NULL              | $2y$12$dyZ.osNBMxQ39l1TbZfZ3.tspc/815at/3BNh3.tKAAk3OR1tiWZ. | NULL           | 2026-02-07 22:48:21 | 2026-02-07 22:48:21 |
+----+-----------------+--------------------+-------------------+--------------------------------------------------------------+----------------+---------------------+---------------------+
10 rows in set (0.00 sec)

mysql> 
```

1. Ahora si, podemos ir creando alguna tarea interactiva
- Yo prefiero hacerlo mediante un metodo separado en el TasksSeeder.php