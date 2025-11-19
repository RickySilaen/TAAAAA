# 🎨 Quick CSS Reference - Dashboard Improvements

## 🚀 Penggunaan Cepat

### Stat Cards
```html
<div class="stat-card stat-card-green">
    <div class="stat-card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <p class="stat-label">Label</p>
                <h3 class="stat-value">1234</h3>
                <span class="stat-badge badge bg-success-soft">
                    <i class="fas fa-arrow-up"></i> +12%
                </span>
            </div>
            <div class="stat-icon stat-icon-green">
                <i class="fas fa-icon"></i>
            </div>
        </div>
    </div>
    <div class="stat-card-footer">
        <a href="#" class="stat-link">
            Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
```

### Color Variants:
- `.stat-card-green` - Hijau (Success)
- `.stat-card-blue` - Biru (Primary)
- `.stat-card-yellow` - Kuning (Warning)
- `.stat-card-purple` - Ungu (Info)

---

## 📦 Modern Cards

```html
<div class="modern-card">
    <div class="modern-card-header">
        <div>
            <h5 class="modern-card-title">Judul Card</h5>
            <p class="modern-card-subtitle">Subtitle card</p>
        </div>
        <a href="#" class="btn btn-sm btn-outline-success">Action</a>
    </div>
    <div class="modern-card-body">
        <!-- Content here -->
    </div>
</div>
```

---

## 🎯 Quick Action Buttons

```html
<a href="#" class="quick-action-btn-large">
    <div class="quick-action-icon-large">
        <i class="fas fa-plus"></i>
    </div>
    <div class="quick-action-text">
        <span class="quick-action-label">Action Label</span>
        <span class="quick-action-desc">Description text</span>
    </div>
</a>
```

---

## 🏷️ Badges

```html
<!-- Soft Backgrounds -->
<span class="badge bg-success-soft">Success</span>
<span class="badge bg-primary-soft">Primary</span>
<span class="badge bg-warning-soft">Warning</span>
<span class="badge bg-danger-soft">Danger</span>
<span class="badge bg-purple-soft">Purple</span>
<span class="badge bg-info-soft">Info</span>
```

---

## 🔔 Notifications

```html
<div class="notification-item unread">
    <div class="notification-icon">
        <i class="fas fa-bell"></i>
    </div>
    <div class="notification-content">
        <h6 class="notification-title">Notification Title</h6>
        <p class="notification-message">Message text</p>
        <small class="notification-time">5 minutes ago</small>
    </div>
</div>
```

---

## 🎨 Color Variables

```css
/* Main Colors */
--green: #27ae60
--dark-green: #1e8449
--primary-blue: #3498db
--yellow: #ffb300
--purple: #6B46C1

/* Neutral Colors */
--primary-dark: #2D3748
--text-gray: #4A5568
--light-bg: #F7FAFC
--border-color: #E2E8F0

/* Soft Colors */
--success-soft: rgba(39, 174, 96, 0.1)
--primary-soft: rgba(52, 152, 219, 0.1)
--warning-soft: rgba(255, 179, 0, 0.1)
--purple-soft: rgba(107, 70, 193, 0.1)
```

---

## 💫 Animations

```css
/* Fade In Up */
animation: fadeInUp 0.6s ease-out;

/* Stagger Animation */
.item:nth-child(1) { animation-delay: 0.1s; }
.item:nth-child(2) { animation-delay: 0.2s; }
.item:nth-child(3) { animation-delay: 0.3s; }
.item:nth-child(4) { animation-delay: 0.4s; }
```

---

## 📏 Spacing

```css
/* Border Radius */
--border-radius-sm: 8px
--border-radius-md: 12px
--border-radius-lg: 16px
--border-radius-xl: 20px

/* Shadows */
--shadow-sm: 0 2px 4px rgba(0,0,0,0.05)
--shadow-md: 0 4px 6px rgba(0,0,0,0.07)
--shadow-lg: 0 10px 20px rgba(0,0,0,0.1)
--shadow-xl: 0 20px 40px rgba(0,0,0,0.15)
```

---

## 🔧 Utility Classes

### Hover Effects:
```css
.hover-lift:hover {
    transform: translateY(-2px);
}

.hover-scale:hover {
    transform: scale(1.05);
}
```

### Gradients:
```css
background: linear-gradient(135deg, color1, color2);
```

### Transitions:
```css
transition: all 0.3s ease;
transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
```

---

## 📱 Responsive Breakpoints

```css
/* Mobile */
@media (max-width: 768px) { }

/* Tablet */
@media (min-width: 769px) and (max-width: 1024px) { }

/* Desktop */
@media (min-width: 1025px) { }
```

---

## ✨ Best Practices

### 1. **Always use CSS variables**
```css
color: var(--green);
background: var(--light-bg);
```

### 2. **Consistent spacing**
```css
padding: 1.5rem;
margin-bottom: 1rem;
gap: 1rem;
```

### 3. **Smooth transitions**
```css
transition: all 0.3s ease;
```

### 4. **Box shadows for depth**
```css
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
```

### 5. **Border radius for modern look**
```css
border-radius: 12px;
```

---

## 🎯 Common Patterns

### Card with Hover:
```css
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
}
```

### Button with Gradient:
```css
.btn-custom {
    background: linear-gradient(135deg, #27ae60, #1e8449);
    transition: all 0.3s ease;
}
.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}
```

### Icon with Animation:
```css
.icon {
    transition: transform 0.3s ease;
}
.icon:hover {
    transform: scale(1.1) rotate(5deg);
}
```

---

## 📊 Performance Tips

1. **Use transform instead of position**
   ```css
   /* ✅ Good */
   transform: translateY(-5px);
   
   /* ❌ Avoid */
   top: -5px;
   ```

2. **Use opacity for fade effects**
   ```css
   opacity: 0.85;
   ```

3. **Leverage GPU acceleration**
   ```css
   transform: translateZ(0);
   will-change: transform;
   ```

---

## 🎨 Color Combinations

### Success Theme:
```css
background: rgba(39, 174, 96, 0.1);
color: #1e8449;
border: 1px solid rgba(39, 174, 96, 0.2);
```

### Primary Theme:
```css
background: rgba(52, 152, 219, 0.1);
color: #2980b9;
border: 1px solid rgba(52, 152, 219, 0.2);
```

### Warning Theme:
```css
background: rgba(255, 179, 0, 0.1);
color: #e6a000;
border: 1px solid rgba(255, 179, 0, 0.2);
```

---

## 🔍 Debugging Tips

### Check Element Styles:
```javascript
// In browser console
getComputedStyle(document.querySelector('.stat-card'))
```

### Force Hover State:
```javascript
// In DevTools Elements tab
:hov > :hover ✓
```

### Clear Cache:
```
Ctrl + Shift + R (Hard Reload)
```

---

**Quick Reference v2.0**  
Last Updated: 12 November 2025
