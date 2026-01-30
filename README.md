# Gestión de Parking - Symfony

Este proyecto fue desarrollado como **prueba técnica** siguiendo requerimientos específicos.  
El objetivo fue implementar un sistema de gestión de estacionamiento con autenticación, API REST y vistas básicas en Symfony.

⚠️ **Disclaimer**  
Las credenciales expuestas en fixtures y documentación son únicamente para fines de demo.  
En un entorno real, se utilizarían variables de entorno y mecanismos seguros de autenticación.  

---

## 🚀 Instalación y ejecución

1. Clonar el repositorio:
   git clone https://github.com/SofiaMarzari/php-gestionparking-symfony.git
   cd php-gestionparking-symfony

2- Instalar dependencias:
      composer install
      npm install
3- Configurar base de datos en .env:
      DATABASE_URL="mysql://user:password@127.0.0.1:3306/parking"
4- Ejecutar migraciones y fixtures:
      php bin/console doctrine:migrations:migrate
      php bin/console doctrine:fixtures:load
5- Registro - Login
Por razones de seguridad los usuarios deben ser registrados por un administrador mediante el 'http://seekerparking.local/register' o para el caso de admin test inicial 
debe realizarse mediante el bundle fixture que registrara las siguientes 
🔑 Credenciales de demo
      - Admin: admin@demo.com / 123456
      - Usuario: user@demo.com / 123456
para esto se debe ejecutar por consola el comando:# php bin/console doctrine:fixtures:load # ¡Advertencia!: elimina los datos existentes de la tabla implicada para User. No ejecutar en entornos de producción.

6- Levantar servidor:
symfony serve


📖 API (Ver documentación completa en _documentacion/notas_desarrollo_api.txt)





