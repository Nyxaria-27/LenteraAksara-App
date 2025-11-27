@echo off
REM ================================================
REM LENTERA AKSARA - FEATURE TOGGLE SCRIPT
REM Quick switch between TO USK and FULL version
REM ================================================

echo.
echo ================================================
echo   LENTERA AKSARA - FEATURE TOGGLE
echo ================================================
echo.
echo Choose configuration:
echo.
echo [1] TO USK MODE      (Hide all challenge features)
echo [2] FULL MODE        (Show all challenge features)
echo [3] Cancel
echo.

choice /c 123 /n /m "Enter your choice (1-3): "

if errorlevel 3 goto :cancel
if errorlevel 2 goto :full
if errorlevel 1 goto :tousk

:tousk
echo.
echo [*] Switching to TO USK MODE...
echo [*] Copying .env.to-usk to .env...
copy /Y .env.to-usk .env >nul
echo [*] Clearing cache...
php artisan config:clear
php artisan view:clear
echo.
echo ================================================
echo   SUCCESS! TO USK MODE ENABLED
echo ================================================
echo.
echo Features HIDDEN:
echo   - Translation (ID/EN)
echo   - Dark Mode Toggle
echo   - Reviews ^& Ratings
echo   - Wishlist
echo   - Notifications
echo   - AOS Animations
echo   - PDF Invoice
echo.
echo Refresh browser with Ctrl+F5 to see changes!
echo ================================================
goto :end

:full
echo.
echo [*] Switching to FULL MODE...
echo [*] Copying .env.full to .env...
copy /Y .env.full .env >nul
echo [*] Clearing cache...
php artisan config:clear
php artisan view:clear
echo.
echo ================================================
echo   SUCCESS! FULL MODE ENABLED
echo ================================================
echo.
echo All features ENABLED:
echo   - Translation (ID/EN)
echo   - Dark Mode Toggle
echo   - Reviews ^& Ratings
echo   - Wishlist
echo   - AOS Animations
echo   - PDF Invoice
echo   - Cart ^& Orders
echo   - Notifications
echo.
echo Refresh browser with Ctrl+F5 to see changes!
echo ================================================
goto :end

:cancel
echo.
echo [!] Operation cancelled.
goto :end

:end
echo.
pause
