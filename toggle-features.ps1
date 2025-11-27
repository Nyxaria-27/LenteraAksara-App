# ================================================
# LENTERA AKSARA - FEATURE TOGGLE SCRIPT (PowerShell)
# Quick switch between TO USK and FULL version
# ================================================

Write-Host ""
Write-Host "================================================" -ForegroundColor Cyan
Write-Host "  LENTERA AKSARA - FEATURE TOGGLE" -ForegroundColor Yellow
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Choose configuration:" -ForegroundColor White
Write-Host ""
Write-Host "[1] TO USK MODE  " -NoNewline -ForegroundColor Red
Write-Host "(Hide all challenge features)" -ForegroundColor Gray
Write-Host "[2] FULL MODE    " -NoNewline -ForegroundColor Green
Write-Host "(Show all challenge features)" -ForegroundColor Gray
Write-Host "[3] Cancel" -ForegroundColor Gray
Write-Host ""

$choice = Read-Host "Enter your choice (1-3)"

switch ($choice) {
    "1" {
        Write-Host ""
        Write-Host "[*] Switching to TO USK MODE..." -ForegroundColor Yellow
        Write-Host "[*] Copying .env.to-usk to .env..." -ForegroundColor Gray
        
        Copy-Item -Path ".env.to-usk" -Destination ".env" -Force
        
        Write-Host "[*] Clearing cache..." -ForegroundColor Gray
        php artisan config:clear | Out-Null
        php artisan view:clear | Out-Null
        
        Write-Host ""
        Write-Host "================================================" -ForegroundColor Green
        Write-Host "  ✅ SUCCESS! TO USK MODE ENABLED" -ForegroundColor Green
        Write-Host "================================================" -ForegroundColor Green
        Write-Host ""
        Write-Host "Features HIDDEN:" -ForegroundColor Yellow
        Write-Host "  ❌ Translation (ID/EN)" -ForegroundColor Red
        Write-Host "  ❌ Dark Mode Toggle" -ForegroundColor Red
        Write-Host "  ❌ Reviews & Ratings" -ForegroundColor Red
        Write-Host "  ❌ Wishlist" -ForegroundColor Red
        Write-Host "  ❌ Notifications" -ForegroundColor Red
        Write-Host "  ❌ AOS Animations" -ForegroundColor Red
        Write-Host "  ❌ PDF Invoice" -ForegroundColor Red
        Write-Host ""
        Write-Host "🔄 Refresh browser with Ctrl+F5 to see changes!" -ForegroundColor Cyan
        Write-Host "================================================" -ForegroundColor Green
    }
    
    "2" {
        Write-Host ""
        Write-Host "[*] Switching to FULL MODE..." -ForegroundColor Yellow
        Write-Host "[*] Copying .env.full to .env..." -ForegroundColor Gray
        
        Copy-Item -Path ".env.full" -Destination ".env" -Force
        
        Write-Host "[*] Clearing cache..." -ForegroundColor Gray
        php artisan config:clear | Out-Null
        php artisan view:clear | Out-Null
        
        Write-Host ""
        Write-Host "================================================" -ForegroundColor Green
        Write-Host "  ✅ SUCCESS! FULL MODE ENABLED" -ForegroundColor Green
        Write-Host "================================================" -ForegroundColor Green
        Write-Host ""
        Write-Host "All features ENABLED:" -ForegroundColor Yellow
        Write-Host "  ✅ Translation (ID/EN)" -ForegroundColor Green
        Write-Host "  ✅ Dark Mode Toggle" -ForegroundColor Green
        Write-Host "  ✅ Reviews & Ratings" -ForegroundColor Green
        Write-Host "  ✅ Wishlist" -ForegroundColor Green
        Write-Host "  ✅ AOS Animations" -ForegroundColor Green
        Write-Host "  ✅ PDF Invoice" -ForegroundColor Green
        Write-Host "  ✅ Cart & Orders" -ForegroundColor Green
        Write-Host "  ✅ Notifications" -ForegroundColor Green
        Write-Host ""
        Write-Host "🔄 Refresh browser with Ctrl+F5 to see changes!" -ForegroundColor Cyan
        Write-Host "================================================" -ForegroundColor Green
    }
    
    "3" {
        Write-Host ""
        Write-Host "[!] Operation cancelled." -ForegroundColor Yellow
    }
    
    default {
        Write-Host ""
        Write-Host "[!] Invalid choice. Please run the script again." -ForegroundColor Red
    }
}

Write-Host ""
Read-Host "Press Enter to exit"
