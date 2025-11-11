// MARIANCONNECT - St. Mary's College of Catbalogan JavaScript

// Sample News Data (In production, this will come from PHP/MySQL)
let newsData = [
    {
        id: 1,
        title: 'SMCC Celebrates Foundation Day 2025',
        date: '2025-10-15',
        category: 'Events',
        excerpt: 'St. Mary\'s College of Catbalogan commemorates another year of academic excellence and service to the community.',
        content: 'The institution held a week-long celebration featuring academic competitions, cultural performances, and community outreach programs. Students, faculty, and alumni gathered to celebrate the rich history and achievements of SMCC.',
        imageUrl: '' // Add image URL here
    },
    {
        id: 2,
        title: 'New Computer Laboratory Opens',
        date: '2025-09-20',
        category: 'Facilities',
        excerpt: 'State-of-the-art computer lab now available for BSCS students.',
        content: 'The new facility features 50 high-performance computers with the latest software for programming and development. This investment in technology ensures that our students receive hands-on training with industry-standard tools.',
        imageUrl: ''
    },
    {
        id: 3,
        title: 'SMCC Students Win Regional Competition',
        date: '2025-08-10',
        category: 'Achievements',
        excerpt: 'College of Computer Science students bring home awards from regional tech competition.',
        content: 'The team showcased innovative solutions in software development and earned recognition for their outstanding performance. This achievement highlights the quality education and mentorship provided at SMCC.',
        imageUrl: ''
    },
    {
        id: 4,
        title: 'Enrollment for SY 2025-2026 Now Open',
        date: '2025-04-01',
        category: 'Announcements',
        excerpt: 'SMCC is now accepting enrollees for the upcoming school year.',
        content: 'Interested students can visit the Admissions Office or contact us through our official channels. Early enrollment is encouraged to secure slots in your preferred programs.',
        imageUrl: ''
    },
    {
        id: 5,
        title: 'SMCC Holds Community Outreach Program',
        date: '2025-07-15',
        category: 'Events',
        excerpt: 'Students and faculty reach out to local communities through various service activities.',
        content: 'The outreach program included medical missions, feeding programs, and educational seminars. This initiative reflects SMCC\'s commitment to social responsibility and community service.',
        imageUrl: ''
    },
    {
        id: 6,
        title: 'Library Expands Digital Collection',
        date: '2025-06-20',
        category: 'Facilities',
        excerpt: 'SMCC Library now offers more e-books and online research databases.',
        content: 'Students and faculty now have access to thousands of digital resources for research and learning. The expanded collection includes academic journals, e-books, and multimedia materials.',
        imageUrl: ''
    }
];

// Student Activities Data (editable by admin)
let studentActivities = [
    'Intramural Sports Competition',
    'Academic Quiz Competitions',
    'Cultural Festival',
    'Leadership Training Programs',
    'Community Outreach Programs',
    'Talent Shows and Concerts'
];

// Gallery Data
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

// Admin Authentication
let isAdminLoggedIn = false;
const ADMIN_PASSWORD = 'admin123'; // In production, use secure authentication

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadNews();
    loadGallery();
    setupEventListeners();
    checkAdminRoute(); // Check if accessing /admin URL
    showPage('home');
    trackPageVisit(); // Track initial page load
});

// Check if accessing admin route
function checkAdminRoute() {
    const path = window.location.pathname;
    const hash = window.location.hash;
    
    // Check if URL contains /admin or #admin
    if (path.includes('/admin') || hash === '#admin') {
        showPage('admin');
    }
}

// Listen for hash changes (for /admin access)
window.addEventListener('hashchange', function() {
    if (window.location.hash === '#admin') {
        showPage('admin');
    }
});

// Setup Event Listeners
function setupEventListeners() {
    // Navigation links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            showPage(page);
            
            // Update active class
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Close mobile menu if open
            document.getElementById('navMenu').classList.remove('active');
        });
    });

    // Quick link cards
    const linkCards = document.querySelectorAll('.link-card');
    linkCards.forEach(card => {
        card.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            if (page) showPage(page);
        });
    });

    // CTA buttons
    const ctaButtons = document.querySelectorAll('[data-page]');
    ctaButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            if (page) showPage(page);
        });
    });

    // Search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            performSearch(this.value);
        });
    }
}

// Page Navigation
function showPage(pageName) {
    // Hide all pages
    const pages = document.querySelectorAll('.page-content');
    pages.forEach(page => page.classList.remove('active'));
    
    // Show selected page
    const targetPage = document.getElementById(pageName + 'Page');
    if (targetPage) {
        targetPage.classList.add('active');
        window.scrollTo(0, 0);
    }
    
    // Update URL without page reload
    if (pageName === 'admin') {
        window.history.pushState({}, '', '/admin');
    }
}

// Check if accessing admin route
function checkAdminRoute() {
    const path = window.location.pathname;
    if (path === '/admin' || path.includes('/admin')) {
        showPage('admin');
    }
}

// Toggle Mobile Menu
function toggleMobileMenu() {
    const navMenu = document.getElementById('navMenu');
    navMenu.classList.toggle('active');
}

// Toggle Search Modal
function toggleSearch() {
    const searchModal = document.getElementById('searchModal');
    searchModal.classList.toggle('active');
    
    if (searchModal.classList.contains('active')) {
        document.getElementById('searchInput').focus();
    } else {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchResults').innerHTML = '';
    }
}

// Perform Search
function performSearch(query) {
    const resultsContainer = document.getElementById('searchResults');
    
    if (query.length < 2) {
        resultsContainer.innerHTML = '';
        return;
    }
    
    // Search in news
    const results = newsData.filter(news => 
        news.title.toLowerCase().includes(query.toLowerCase()) ||
        news.content.toLowerCase().includes(query.toLowerCase()) ||
        news.category.toLowerCase().includes(query.toLowerCase())
    );
    
    if (results.length === 0) {
        resultsContainer.innerHTML = '<div class="search-result-item"><p>No results found</p></div>';
        return;
    }
    
    let html = '';
    results.forEach(result => {
        html += `
            <div class="search-result-item" onclick="showNewsDetail(${result.id})">
                <h4>${result.title}</h4>
                <p>${result.excerpt}</p>
            </div>
        `;
    });
    
    resultsContainer.innerHTML = html;
}

// Load News
function loadNews() {
    // Load news for home page (latest 3)
    const homeNewsGrid = document.getElementById('homeNewsGrid');
    if (homeNewsGrid) {
        const latestNews = newsData.slice(0, 3);
        homeNewsGrid.innerHTML = generateNewsHTML(latestNews);
    }
    
    // Load all news for news page
    const newsGrid = document.getElementById('newsGrid');
    if (newsGrid) {
        newsGrid.innerHTML = generateNewsHTML(newsData);
    }
    
    // Load news table for admin
    loadAdminNewsTable();
}

// Generate News HTML
function generateNewsHTML(newsArray) {
    let html = '';
    newsArray.forEach(news => {
        const imageSection = news.imageUrl 
            ? `<div class="news-image" style="background-image: url('${news.imageUrl}');"></div>`
            : `<div class="news-image">📰</div>`;
        
        html += `
            <div class="news-card" onclick="showNewsDetail(${news.id})">
                ${imageSection}
                <div class="news-content">
                    <div class="news-date">${formatDate(news.date)}</div>
                    <h3>${news.title}</h3>
                    <p>${news.excerpt}</p>
                    <span class="news-category">${news.category}</span>
                </div>
            </div>
        `;
    });
    return html;
}

// Show News Detail (You can enhance this to show full article)
function showNewsDetail(newsId) {
    const news = newsData.find(n => n.id === newsId);
    if (news) {
        alert(`${news.title}\n\n${news.content}\n\nDate: ${formatDate(news.date)}\nCategory: ${news.category}`);
        // In production, you would show this in a modal or dedicated page
    }
}

// Format Date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

// Load Gallery
function loadGallery() {
    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        displayGallery(galleryData);
    }
}

// Load Student Activities
function loadStudentActivities() {
    const activitiesList = document.getElementById('studentActivitiesList');
    if (activitiesList) {
        let html = '<ul>';
        studentActivities.forEach(activity => {
            html += `<li>${activity}</li>`;
        });
        html += '</ul>';
        activitiesList.innerHTML = html;
    }
}

// Display Gallery
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

// Filter Gallery
function filterGallery(category) {
    // Update active filter button
    const filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter gallery items
    if (category === 'all') {
        displayGallery(galleryData);
    } else {
        const filtered = galleryData.filter(item => item.category === category);
        displayGallery(filtered);
    }
}

// Show Program Tab
function showProgramTab(tab) {
    // Update active tab button
    const tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Show/hide program content
    document.getElementById('basicPrograms').style.display = tab === 'basic' ? 'block' : 'none';
    document.getElementById('collegePrograms').style.display = tab === 'college' ? 'block' : 'none';
}

// Admin Functions
function adminLogin(event) {
    event.preventDefault();
    const password = document.getElementById('adminPasswordInput').value;
    
    if (password === ADMIN_PASSWORD) {
        isAdminLoggedIn = true;
        document.getElementById('adminLogin').style.display = 'none';
        document.getElementById('adminDashboard').style.display = 'block';
        loadAdminNewsTable();
    } else {
        alert('Incorrect password!');
    }
    
    return false;
}

function adminLogout() {
    isAdminLoggedIn = false;
    document.getElementById('adminLogin').style.display = 'flex';
    document.getElementById('adminDashboard').style.display = 'none';
    document.getElementById('adminPasswordInput').value = '';
}

function showAddNewsForm() {
    document.getElementById('addNewsForm').style.display = 'block';
    // Set today's date as default
    document.getElementById('newsDate').valueAsDate = new Date();
}

function hideAddNewsForm() {
    document.getElementById('addNewsForm').style.display = 'none';
    // Clear form
    document.getElementById('newsTitle').value = '';
    document.getElementById('newsDate').value = '';
    document.getElementById('newsCategory').value = 'Events';
    document.getElementById('newsExcerpt').value = '';
    document.getElementById('newsContent').value = '';
}

function addNews(event) {
    event.preventDefault();
    
    const newNews = {
        id: newsData.length + 1,
        title: document.getElementById('newsTitle').value,
        date: document.getElementById('newsDate').value,
        category: document.getElementById('newsCategory').value,
        excerpt: document.getElementById('newsExcerpt').value,
        content: document.getElementById('newsContent').value,
        imageUrl: document.getElementById('newsImageUrl').value
    };
    
    // In production, this would be sent to PHP backend
    newsData.unshift(newNews); // Add to beginning of array
    
    // Reload displays
    loadNews();
    hideAddNewsForm();
    
    alert('News posted successfully!');
    return false;
}

function loadAdminNewsTable() {
    const tableBody = document.getElementById('adminNewsTable');
    if (!tableBody) return;
    
    let html = '';
    newsData.forEach(news => {
        const imagePreview = news.imageUrl 
            ? `<img src="${news.imageUrl}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;" alt="News">` 
            : '📰';
        
        html += `
            <tr>
                <td>${news.title}</td>
                <td>${formatDate(news.date)}</td>
                <td>${news.category}</td>
                <td style="text-align: center;">${imagePreview}</td>
                <td>
                    <button class="action-btn edit-btn" onclick="editNews(${news.id})">✏️ Edit</button>
                    <button class="action-btn delete-btn" onclick="deleteNews(${news.id})">🗑️ Delete</button>
                </td>
            </tr>
        `;
    });
    
    tableBody.innerHTML = html;
}

function editNews(newsId) {
    const news = newsData.find(n => n.id === newsId);
    if (news) {
        // Show edit form
        document.getElementById('editNewsForm').style.display = 'block';
        document.getElementById('addNewsForm').style.display = 'none';
        
        // Populate form
        document.getElementById('editNewsId').value = news.id;
        document.getElementById('editNewsTitle').value = news.title;
        document.getElementById('editNewsDate').value = news.date;
        document.getElementById('editNewsCategory').value = news.category;
        document.getElementById('editNewsImageUrl').value = news.imageUrl || '';
        document.getElementById('editNewsExcerpt').value = news.excerpt;
        document.getElementById('editNewsContent').value = news.content;
        
        // Scroll to form
        document.getElementById('editNewsForm').scrollIntoView({ behavior: 'smooth' });
    }
}

function updateNews(event) {
    event.preventDefault();
    
    const newsId = parseInt(document.getElementById('editNewsId').value);
    const newsIndex = newsData.findIndex(n => n.id === newsId);
    
    if (newsIndex !== -1) {
        newsData[newsIndex] = {
            id: newsId,
            title: document.getElementById('editNewsTitle').value,
            date: document.getElementById('editNewsDate').value,
            category: document.getElementById('editNewsCategory').value,
            excerpt: document.getElementById('editNewsExcerpt').value,
            content: document.getElementById('editNewsContent').value,
            imageUrl: document.getElementById('editNewsImageUrl').value
        };
        
        // Reload displays
        loadNews();
        hideEditNewsForm();
        
        alert('News updated successfully!');
    }
    
    return false;
}

function hideEditNewsForm() {
    document.getElementById('editNewsForm').style.display = 'none';
    // Clear form
    document.getElementById('editNewsId').value = '';
    document.getElementById('editNewsTitle').value = '';
    document.getElementById('editNewsDate').value = '';
    document.getElementById('editNewsCategory').value = 'Events';
    document.getElementById('editNewsImageUrl').value = '';
    document.getElementById('editNewsExcerpt').value = '';
    document.getElementById('editNewsContent').value = '';
}

function deleteNews(newsId) {
    if (confirm('Are you sure you want to delete this news item?')) {
        // In production, this would send delete request to PHP backend
        newsData = newsData.filter(n => n.id !== newsId);
        loadNews();
        alert('News deleted successfully!');
    }
}

// Utility Functions
function getCurrentDate() {
    const today = new Date();
    return today.toISOString().split('T')[0];
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const navMenu = document.getElementById('navMenu');
    const mobileToggle = document.querySelector('.mobile-toggle');
    
    if (navMenu && mobileToggle) {
        if (!navMenu.contains(event.target) && !mobileToggle.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    }
});

// Close search modal when clicking outside
document.addEventListener('click', function(event) {
    const searchModal = document.getElementById('searchModal');
    const searchBox = document.querySelector('.search-box');
    const searchBtn = document.querySelector('.search-btn');
    
    if (searchModal && searchBox && searchBtn) {
        if (searchModal.classList.contains('active') && 
            !searchBox.contains(event.target) && 
            !searchBtn.contains(event.target)) {
            toggleSearch();
        }
    }
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
});

// Analytics Functions
/**
 * Track page visit for analytics
 */
function trackPageVisit() {
    const pageData = {
        page_url: window.location.pathname,
        page_title: document.title
    };
    
    // Send to PHP backend
    fetch('php/analytics.php?action=track', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(pageData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Page visit tracked');
        }
    })
    .catch(error => {
        console.error('Analytics error:', error);
    });
}

/**
 * Load analytics dashboard
 */
function loadAnalyticsDashboard() {
    if (!isAdminLoggedIn) return;
    
    fetch('php/analytics.php')
        .then(response => response.json())
        .then(data => {
            displayAnalyticsDashboard(data);
        })
        .catch(error => {
            console.error('Error loading analytics:', error);
        });
}

/**
 * Display analytics dashboard
 */
function displayAnalyticsDashboard(data) {
    console.log('Analytics Dashboard Data:', data);
    // You can create a dashboard page to display this data
    // For now, it's logged to console
}

console.log('MARIANCONNECT initialized successfully!');
