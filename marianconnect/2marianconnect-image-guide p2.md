# MARIANCONNECT - Image Setup Guide

## 📸 Complete Guide to Adding Images

This guide will help you add all the background images and photos to make MARIANCONNECT look professional and unique!

---

## 📁 Folder Structure

Create these folders inside your `marianconnect` directory:

```
marianconnect/
├── images/
│   ├── hero-bg.jpg              ← Hero section background
│   ├── smcc-logo.png            ← College logo
│   ├── quickaccess/             ← Quick access card backgrounds
│   │   ├── programs-bg.jpg
│   │   ├── admissions-bg.jpg
│   │   ├── student-affairs-bg.jpg
│   │   └── facilities-bg.jpg
│   ├── programs/                ← College program logos
│   │   ├── bscs-logo.jpg
│   │   ├── bsa-logo.jpg
│   │   ├── bsbm-logo.jpg
│   │   ├── bshm-logo.jpg
│   │   ├── beed-logo.jpg
│   │   └── bsed-logo.jpg
│   ├── organizations/           ← Student organization logos
│   │   ├── ssc-logo.jpg
│   │   ├── jpcs-logo.jpg
│   │   └── jpia-logo.jpg
│   ├── facilities/              ← Actual facility photos
│   │   ├── campus-grounds.jpg
│   │   ├── library.jpg
│   │   ├── computer-lab.jpg
│   │   ├── sports-complex.jpg
│   │   ├── chapel.jpg
│   │   ├── science-lab.jpg
│   │   ├── canteen.jpg
│   │   └── clinic.jpg
│   └── news/                    ← News article images
│       ├── foundation-day.jpg
│       ├── computer-lab-opening.jpg
│       └── ...
```

---

## 🎨 Image Requirements

### Recommended Sizes:
- **Hero Background**: 1920x1080px (landscape)
- **Quick Access Cards**: 800x600px (landscape)
- **Program Logos**: 400x400px (square)
- **Organization Logos**: 400x400px (square)
- **Facility Photos**: 1200x800px (landscape)
- **News Images**: 800x600px (landscape)
- **SMCC Logo**: 200x200px (square, transparent background)

### Image Format:
- Use JPG for photos
- Use PNG for logos (for transparency)
- Keep file sizes under 500KB for fast loading

---

## 🖼️ Step-by-Step Setup

### 1. Hero Section Background

**File**: `images/hero-bg.jpg`

**What to use**: A beautiful photo of SMCC campus, students, or building facade

**How it works**: The CSS already has the gradient overlay (#15008C at 62% opacity), so just add your image to the folder and it will automatically apply!

No code changes needed - it's already set up in the CSS!

---

### 2. Quick Access Card Backgrounds

Add these 4 images to `images/quickaccess/`:

**Files needed**:
- `programs-bg.jpg` - Photo of students in classroom or books
- `admissions-bg.jpg` - Photo of admission office or students registering
- `student-affairs-bg.jpg` - Photo of student activities or organizations
- `facilities-bg.jpg` - Photo of campus facilities

**How to activate**: Add this CSS to your `styles.css`:

```css
/* Add to the end of styles.css */

/* Quick Access Backgrounds */
.link-card[data-bg="programs-bg"] {
    background-image: url('../images/quickaccess/programs-bg.jpg');
}

.link-card[data-bg="admissions-bg"] {
    background-image: url('../images/quickaccess/admissions-bg.jpg');
}

.link-card[data-bg="student-affairs-bg"] {
    background-image: url('../images/quickaccess/student-affairs-bg.jpg');
}

.link-card[data-bg="facilities-bg"] {
    background-image: url('../images/quickaccess/facilities-bg.jpg');
}
```

---

### 3. College Program Logos

Add these 6 department logos to `images/programs/`:

**Files needed**:
- `bscs-logo.jpg` - Computer Science logo
- `bsa-logo.jpg` - Accountancy logo
- `bsbm-logo.jpg` - Business Management logo
- `bshm-logo.jpg` - Hospitality Management logo
- `beed-logo.jpg` - Elementary Education logo
- `bsed-logo.jpg` - Secondary Education logo

**How to activate**: Add this CSS to your `styles.css`:

```css
/* Add to the end of styles.css */

/* College Program Backgrounds */
.program-card-image[data-program="bscs"] {
    background-image: url('../images/programs/bscs-logo.jpg');
}

.program-card-image[data-program="bsa"] {
    background-image: url('../images/programs/bsa-logo.jpg');
}

.program-card-image[data-program="bsbm"] {
    background-image: url('../images/programs/bsbm-logo.jpg');
}

.program-card-image[data-program="bshm"] {
    background-image: url('../images/programs/bshm-logo.jpg');
}

.program-card-image[data-program="beed"] {
    background-image: url('../images/programs/beed-logo.jpg');
}

.program-card-image[data-program="bsed"] {
    background-image: url('../images/programs/bsed-logo.jpg');
}
```

---

### 4. Student Organization Logos

Add these 3 organization logos to `images/organizations/`:

**Files needed**:
- `ssc-logo.jpg` - Supreme Student Council logo
- `jpcs-logo.jpg` - Junior Philippine Computer Society logo
- `jpia-logo.jpg` - Junior Philippine Institute of Accountants logo

**How to activate**: Add this CSS to your `styles.css`:

```css
/* Add to the end of styles.css */

/* Organization Backgrounds */
.organization-card[data-org="ssc"] {
    background-image: url('../images/organizations/ssc-logo.jpg');
}

.organization-card[data-org="jpcs"] {
    background-image: url('../images/organizations/jpcs-logo.jpg');
}

.organization-card[data-org="jpia"] {
    background-image: url('../images/organizations/jpia-logo.jpg');
}
```

---

### 5. Facilities Gallery Photos

Add these 8 photos to `images/facilities/`:

**Files needed**:
- `campus-grounds.jpg`
- `library.jpg`
- `computer-lab.jpg`
- `sports-complex.jpg`
- `chapel.jpg`
- `science-lab.jpg`
- `canteen.jpg`
- `clinic.jpg`

**How to use**: These will be displayed in the Facilities gallery. Update the `galleryData` in `script.js`:

```javascript
// Update in script.js
const galleryData = [
    { id: 1, title: 'Campus Grounds', category: 'campus', icon: '🏫', imageUrl: 'images/facilities/campus-grounds.jpg' },
    { id: 2, title: 'Library', category: 'facilities', icon: '📚', imageUrl: 'images/facilities/library.jpg' },
    { id: 3, title: 'Computer Laboratory', category: 'facilities', icon: '💻', imageUrl: 'images/facilities/computer-lab.jpg' },
    { id: 4, title: 'Sports Complex', category: 'campus', icon: '⚽', imageUrl: 'images/facilities/sports-complex.jpg' },
    { id: 5, title: 'Chapel', category: 'campus', icon: '⛪', imageUrl: 'images/facilities/chapel.jpg' },
    { id: 6, title: 'Science Laboratory', category: 'facilities', icon: '🔬', imageUrl: 'images/facilities/science-lab.jpg' },
    { id: 7, title: 'Canteen', category: 'facilities', icon: '🍽️', imageUrl: 'images/facilities/canteen.jpg' },
    { id: 8, title: 'Clinic', category: 'facilities', icon: '🏥', imageUrl: 'images/facilities/clinic.jpg' }
];
```

Then update the `displayGallery` function:

```javascript
// Update in script.js - replace displayGallery function
function displayGallery(items) {
    const galleryGrid = document.getElementById('galleryGrid');
    let html = '';
    
    items.forEach(item => {
        const bgImage = item.imageUrl ? `style="background-image: url('${item.imageUrl}'); background-size: cover; background-position: center;"` : '';
        html += `
            <div class="gallery-item" data-category="${item.category}">
                <div class="gallery-item-bg" ${bgImage}>${item.imageUrl ? '' : item.icon}</div>
                <div class="gallery-overlay">
                    <h4>${item.title}</h4>
                </div>
            </div>
        `;
    });
    
    galleryGrid.innerHTML = html;
}
```

---

### 6. News Article Images

**How to add images to news**:

When you login as admin and add/edit news, there's now an "Image URL" field. You can:

**Option 1**: Upload image to `images/news/` folder and use relative path:
```
images/news/foundation-day.jpg
```

**Option 2**: Use external URL:
```
https://example.com/image.jpg
```

---

## 🎯 Quick Testing Checklist

After adding images, check:

- [ ] Hero background appears with gradient overlay
- [ ] Quick Access cards show backgrounds on hover
- [ ] College program cards show department logos
- [ ] Organization cards show org logos
- [ ] Facilities gallery shows actual photos
- [ ] News cards show images when added
- [ ] All images load without 404 errors
- [ ] Website still loads fast (images not too large)

---

## 💡 Image Optimization Tips

### Before uploading images:

1. **Resize images** to recommended dimensions
2. **Compress images** using tools like:
   - TinyPNG (https://tinypng.com/)
   - Squoosh (https://squoosh.app/)
   - Photoshop "Save for Web"

3. **Rename files** properly:
   - Use lowercase
   - No spaces (use hyphens)
   - Be descriptive: `computer-lab.jpg` not `IMG001.jpg`

---

## 🚨 Troubleshooting

### Image not showing?
1. Check file path is correct
2. Check file extension (jpg vs jpeg)
3. Check file name spelling
4. Make sure image file exists in folder
5. Clear browser cache (Ctrl + F5)

### Image too dark/light?
- Adjust opacity in CSS
- Use photo editing software
- The gradient overlay is already set!

### Image loading slow?
- Compress image file size
- Recommended: under 500KB each
- Use JPG for photos, not PNG

---

## 📝 Complete CSS Addition

**Copy and paste this at the end of your `styles.css` file:**

```css
/* ============================================
   IMAGE BACKGROUNDS - Add at end of styles.css
   ============================================ */

/* Quick Access Card Backgrounds */
.link-card[data-bg="programs-bg"] {
    background-image: url('../images/quickaccess/programs-bg.jpg');
}

.link-card[data-bg="admissions-bg"] {
    background-image: url('../images/quickaccess/admissions-bg.jpg');
}

.link-card[data-bg="student-affairs-bg"] {
    background-image: url('../images/quickaccess/student-affairs-bg.jpg');
}

.link-card[data-bg="facilities-bg"] {
    background-image: url('../images/quickaccess/facilities-bg.jpg');
}

/* College Program Logo Backgrounds */
.program-card-image[data-program="bscs"] {
    background-image: url('../images/programs/bscs-logo.jpg');
}

.program-card-image[data-program="bsa"] {
    background-image: url('../images/programs/bsa-logo.jpg');
}

.program-card-image[data-program="bsbm"] {
    background-image: url('../images/programs/bsbm-logo.jpg');
}

.program-card-image[data-program="bshm"] {
    background-image: url('../images/programs/bshm-logo.jpg');
}

.program-card-image[data-program="beed"] {
    background-image: url('../images/programs/beed-logo.jpg');
}

.program-card-image[data-program="bsed"] {
    background-image: url('../images/programs/bsed-logo.jpg');
}

/* Student Organization Logo Backgrounds */
.organization-card[data-org="ssc"] {
    background-image: url('../images/organizations/ssc-logo.jpg');
}

.organization-card[data-org="jpcs"] {
    background-image: url('../images/organizations/jpcs-logo.jpg');
}

.organization-card[data-org="jpia"] {
    background-image: url('../images/organizations/jpia-logo.jpg');
}
```

---

## ✅ Final Checklist

Before your thesis defense:

- [ ] All image folders created
- [ ] Hero background image added
- [ ] 4 Quick Access backgrounds added
- [ ] 6 Program logos added
- [ ] 3 Organization logos added
- [ ] 8 Facility photos added
- [ ] CSS code added for backgrounds
- [ ] Test all pages to verify images show
- [ ] Images optimized (file sizes under 500KB)
- [ ] All images professional quality

---

**You're all set! Your MARIANCONNECT website will look amazing with real images! 🎉**

---

*Need help? Review this guide or check the browser console for errors.*
