@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo ====================================================
echo  SystemBomb - Crear proyecto Laravel 12 (Windows)
echo ====================================================
where composer >nul 2>nul
if errorlevel 1 (
  echo ERROR: Composer no esta instalado o no aparece en PATH.
  echo Lee README.md para instalar PHP y Composer.
  pause
  exit /b 1
)
if exist "systembomb_app" (
  echo ERROR: Ya existe carpeta systembomb_app.
  echo Muevela o renombrala para evitar sobrescribir datos.
  pause
  exit /b 1
)
composer create-project "laravel/laravel:^12.0" systembomb_app
if errorlevel 1 goto fail
for %%D in (app routes database resources public tests) do (
  xcopy /E /I /Y "%~dp0%%D" "%~dp0systembomb_app\%%D" >nul
  if errorlevel 1 goto fail
)
cd /d "%~dp0systembomb_app"
php -r "file_put_contents('database/database.sqlite','');"
if errorlevel 1 goto fail
php "%~dp0CONFIGURAR_ENV.php" "%CD%\.env"
php artisan key:generate
if errorlevel 1 goto fail
php artisan migrate
if errorlevel 1 goto fail
php artisan db:seed --class=SystemBombSeeder
if errorlevel 1 goto fail
echo.
echo LISTO. Ahora ejecuta: cd systembomb_app ^&^& php artisan serve
echo Usuario: admin@systembomb.test / Demo2026!
pause
exit /b 0
:fail
echo ERROR al preparar Laravel. Revisa README.md y la terminal.
pause
exit /b 1
