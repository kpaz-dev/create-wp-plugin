# create-wp-plugin

CLI en PHP para generar rápidamente la estructura base de un plugin de WordPress.

## ¿Qué genera?

Al ejecutar el comando se crea una carpeta con:

- Estructura recomendada (`assets`, `inc`, `templates`, `languages`, `src`).
- Archivos `index.php` con _"Silence is golden."_ para evitar indexado.
- Archivo principal del plugin (`<slug>.php`) con cabecera de WordPress.
- `readme.txt` base en formato compatible con WordPress.org.
- Opcionalmente, entorno Docker con WordPress + MariaDB + WP-CLI (`--docker`).

## Requisitos

- PHP `^8.3`
- Composer `^2`

## Instalación

### Opción 1: uso local del repositorio

```bash
composer install
php bin/wp-plugin new mi-plugin
```

### Opción 2: instalación global

```bash
composer global require kpaz/create-wp-plugin
wp-plugin new mi-plugin
```

> Si usas instalación global, asegúrate de tener `~/.composer/vendor/bin` (o su equivalente en tu sistema) en el `PATH`.

## Uso

```bash
wp-plugin new <slug-del-plugin> [--docker]
```

Ejemplo:

```bash
wp-plugin new awesome-seo-tools
```

Esto generará una carpeta `awesome-seo-tools` lista para empezar a desarrollar.


### Generar con Docker

Si agregas `--docker`, además de la estructura del plugin se generan:

- `docker-compose.yml` con servicios de `wordpress`, `db` (MariaDB) y `wpcli`.
- `.env.example` con variables para puertos y credenciales.

Ejemplo:

```bash
wp-plugin new awesome-seo-tools --docker
```

Luego puedes iniciar el entorno con:

```bash
cd awesome-seo-tools
cp .env.example .env
docker compose up -d
```

## Estructura del proyecto (este repositorio)

```text
bin/
  wp-plugin                   # Entry point CLI
src/
  Application.php             # Factory de la aplicación Symfony Console
  Command/
    NewPluginCommand.php      # Comando `new`
  Service/
    PluginScaffolder.php      # Lógica de generación de archivos y carpetas
```

## Desarrollo

Validación rápida:

```bash
composer run lint
```

## Licencia

MIT. Revisa el archivo [LICENSE](LICENSE).
