<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verse - Your Online Blogging Platform</title>
    <link rel="stylesheet" href="css/landing.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Verse</div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#featured-blogs">Featured Blogs</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="hero">
            <h1>Welcome to Verse</h1>
            <p>Express yourself through the power of words</p>
            <a href="test-register.php" class="cta-button">Start Writing</a>
        </section>

        <section id="features">
            <h2>Features</h2>
            <div class="feature-grid">
                <div class="feature">
                    <h3>Easy to Use</h3>
                    <p>Intuitive interface for seamless writing experience</p>
                </div>
                <div class="feature">
                    <h3>Customizable Accounts</h3>
                    <p>Make your blog unique with our theme options</p>
                </div>
                <div class="feature">
                    <h3>Modderation and Friendly Community</h3>
                    <p>Get discovered easily with our built-in SEO tools</p>
                </div>
            </div>
        </section>

        <section id="about">
            <h2>About Verse</h2>
            <p>Verse is a platform dedicated to empowering writers and bloggers to share their stories with the world. Our mission is to provide a space where creativity flourishes and ideas come to life.</p>
        </section>

        <section id="featured-blogs">
            <h2>Featured Blogs</h2>
            <div class="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h3>The Art of Mindful Living</h3>
                        <p>Discover how mindfulness can transform your daily life and boost your overall well-being.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>Mastering the Perfect Sourdough</h3>
                        <p>Unlock the secrets to baking the most delicious and Instagram-worthy sourdough bread at home.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>The Future of Sustainable Fashion</h3>
                        <p>Explore how eco-friendly materials and ethical practices are reshaping the fashion industry.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>Demystifying Quantum Computing</h3>
                        <p>A beginner's guide to understanding the revolutionary world of quantum computing and its potential impact.</p>
                    </div>
                    <div class="carousel-item">
                        <h3>The Hidden Gems of Southeast Asia</h3>
                        <p>Embark on a virtual journey to discover the lesser-known but breathtaking destinations in Southeast Asia.</p>
                    </div>
                </div>
                <button class="carousel-button prev">&lt;</button>
                <button class="carousel-button next">&gt;</button>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Verse. All rights reserved.</p>
    </footer>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('.carousel-inner');
    const items = document.querySelectorAll('.carousel-item');
    const prevButton = document.querySelector('.carousel-button.prev');
    const nextButton = document.querySelector('.carousel-button.next');
    let currentIndex = 0;
    const totalItems = items.length;

    function showItem(index) {
        carousel.style.transform = `translateX(-${index * 100}%)`;
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
    }

    function nextItem() {
        currentIndex = (currentIndex + 1) % totalItems;
        showItem(currentIndex);
    }

    function prevItem() {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        showItem(currentIndex);
    }

    nextButton.addEventListener('click', nextItem);
    prevButton.addEventListener('click', prevItem);

    // Auto-cycle every 5 seconds
    setInterval(nextItem, 5000);
});
</script>

</html>