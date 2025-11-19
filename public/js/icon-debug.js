/**
 * Icon Debug & Fix Script
 * Script untuk memastikan semua icon FontAwesome ditampilkan dengan benar
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('🔍 Icon Debug Script Loaded');
    
    // Check if FontAwesome is loaded
    const fontAwesomeLoaded = document.querySelector('link[href*="font-awesome"]');
    if (fontAwesomeLoaded) {
        console.log('✅ FontAwesome CSS loaded');
    } else {
        console.warn('⚠️ FontAwesome CSS not found');
    }
    
    // Check all stat icons
    const statIcons = document.querySelectorAll('.stat-icon');
    console.log(`📊 Found ${statIcons.length} stat icons`);
    
    statIcons.forEach((icon, index) => {
        const hasIcon = icon.querySelector('i');
        if (hasIcon) {
            const iconClass = hasIcon.className;
            const computedStyle = window.getComputedStyle(hasIcon);
            const color = computedStyle.color;
            const fontSize = computedStyle.fontSize;
            const display = computedStyle.display;
            
            console.log(`Icon ${index + 1}:`, {
                class: iconClass,
                color: color,
                fontSize: fontSize,
                display: display,
                visible: hasIcon.offsetWidth > 0 && hasIcon.offsetHeight > 0
            });
            
            // Force visibility
            if (hasIcon.offsetWidth === 0 || hasIcon.offsetHeight === 0) {
                console.warn(`⚠️ Icon ${index + 1} is hidden, forcing visibility`);
                hasIcon.style.display = 'inline-block';
                hasIcon.style.opacity = '1';
                hasIcon.style.visibility = 'visible';
            }
        } else {
            console.warn(`⚠️ Stat icon ${index + 1} has no <i> element`);
        }
    });
    
    // Function to ensure icons are visible
    function ensureIconsVisible() {
        // All icon containers
        const iconContainers = document.querySelectorAll(
            '.stat-icon, .quick-action-icon-large, .notification-icon, .quick-stat-icon, .tips-icon, .bantuan-icon'
        );
        
        iconContainers.forEach(container => {
            const icon = container.querySelector('i, .fas, .far, .fab');
            if (icon) {
                // Force styles
                icon.style.opacity = '1';
                icon.style.visibility = 'visible';
                icon.style.display = 'inline-block';
                
                // Check parent container
                container.style.display = 'flex';
                container.style.alignItems = 'center';
                container.style.justifyContent = 'center';
            }
        });
    }
    
    // Run immediately
    ensureIconsVisible();
    
    // Run again after a short delay (in case of late CSS loading)
    setTimeout(ensureIconsVisible, 100);
    setTimeout(ensureIconsVisible, 500);
    
    // Add mutation observer to handle dynamic content
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                ensureIconsVisible();
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    console.log('✅ Icon visibility script initialized');
});

// Alternative fallback: Check FontAwesome font loading
if (document.fonts) {
    document.fonts.ready.then(function() {
        console.log('✅ All fonts loaded');
        
        // Force redraw of icons
        const icons = document.querySelectorAll('.fas, .far, .fab');
        icons.forEach(icon => {
            icon.style.fontFamily = '"Font Awesome 6 Free"';
            icon.style.fontWeight = '900';
        });
    });
}
