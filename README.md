## Web - Seeker Parking http://seekerparking.local/
## Registro - Login
Por razones de seguridad los usuarios deben ser registrados por un administrador mediante el 'http://seekerparking.local/register' o para el caso de admin test inicial 
debe realizarse mediante el bundle fixture que registrara las siguientes credenciales de prueba:
    
  Credenciales de Web:
    ° USR: pruebaadmin@gmail.com
    ° PASS: DashAdmin123

  Credenciales de API:
      ° USR: prueba-tecnica@gmail.com
      ° PASS: Admin123!
      
para esto se debe ejecutar por consola el comando:# php bin/console doctrine:fixtures:load # ¡Advertencia!: elimina los datos existentes de la tabla implicada para User. No ejecutar en entornos de producción.

## Documentacion sobre la API Rest:
se encuentra en: _documentacion/notas_desarrollo_api.txt
