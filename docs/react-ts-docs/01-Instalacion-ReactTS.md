# Instalacion del frontend react con typescript
1. Instalarlo con npm, o pnpm, depende ya de cada uno
- Comando -> npm create vite@latest frontend -- --template react-ts
- Explicacion: @latest para que nos ponga la ultima versión de vite, frontend és el nombre que le damos al directorio, donde estará nuestro frontend
```bash
joel-erreyes:~/docsjoel/proyectos personales/laravel-api-cheatsheet$ npm create vite@latest frontend -- --template react-ts
Need to install the following packages:
create-vite@8.2.0
Ok to proceed? (y) y


> npx
> create-vite frontend --template react-ts

│
◇  Use rolldown-vite (Experimental)?:
│  No
│
◇  Install with npm and start now?
│  Yes
│
◇  Scaffolding project in /home/joel-erreyes/docsjoel/proyectos personales/laravel-api-cheatsheet/frontend...
│
◇  Installing dependencies with npm...

added 175 packages, and audited 176 packages in 15s

45 packages are looking for funding
  run `npm fund` for details

found 0 vulnerabilities
│
◇  Starting dev server...

> frontend@0.0.0 dev
> vite
```

2. Nada más instalarlo, nos dará este .gitignore
- Donde nos ignora carpetas innecesarias para el repositorio como node modules, etc...
- **Lo esencial ya está ignorado, pero si en el futuro tenemos archivos como .env se deben de meter al .gitignore**
```.gitignore
# Logs
logs
*.log
npm-debug.log*
yarn-debug.log*
yarn-error.log*
pnpm-debug.log*
lerna-debug.log*

node_modules
dist
dist-ssr
*.local

# Editor directories and files
.vscode/*
!.vscode/extensions.json
.idea
.DS_Store
*.suo
*.ntvs*
*.njsproj
*.sln
*.sw?
```
