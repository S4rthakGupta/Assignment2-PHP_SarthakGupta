<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This is the title for the About me page. -->
    <title>About Me</title>
    <!-- Linking the CSS file which is placed in the public folder. -->
    <link rel="stylesheet" href="public/CSS/style.css">
</head>

<!-- Content for the body starts from here. -->
<body>

    <!-- This is the header and the navbar. It is consistent across all pages. -->
    <header class="header">
        <h1 id="nav-title"><span class="h-span">Fit</span>ness Class</h1>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>

                <!-- Creating an extra About Me section to display my details. -->
                <li><a href="about.php">About Me</a></li>
            </ul>
        </nav>
    </header>

    <!-- The content for the main body starts from here. -->
    <main>
    <div class="container">
            <h1 class="main-h1">About Me</h1>
                <p class="intro-text">
                    <!-- This is a description for myself. -->
                    I am <i id="about-i">Sarthak Gupta</i>, an aspiring<strong> Full-Stack Developer</strong> with a deep passion for technology and innovation. I specialize in creating dynamic, responsive, and user-friendly web applications using modern web technologies such as HTML, CSS, JavaScript, and frameworks like React and Node.js.
                    <br><br>
                    I am constantly learning and exploring new technologies to stay updated in this rapidly evolving field. I believe in the power of community and love connecting with like-minded professionals to share knowledge, collaborate on projects, and grow together. Currently, I am pursuing a <em>Graduate Certificate in Web Development</em> at Conestoga College in Canada, which has further enhanced my skills.
                    <br><br>
                    I'm always open to collaborating on innovative projects or discussing new ideas. Feel free to reach out to me through my portfolio!
                </p>        
            </div>

        <!-- This is the div in which there is my image. -->
        <div class="hero">
            <div class="hero-img">
                <img src="public/sarthakgupta.png" alt="This is my Image.">
            </div>        

            <!-- This is the div in which there are two buttons which redirect to my portfolio and YouTube channel. -->
            <div class="content">
                <p class="intro-text">"Building innovative solutions, one line of code at a time."</p>
                <div class="buttons">
                    <a href="https://sarthak-gupta-portfolio-website.vercel.app/" target="_blank">View My Portfolio</a>
                    <a class="button-yt" href="https://www.youtube.com/@s4rthakgupta" target="_blank">Visit My YouTube Channel</a>
                </div>
            </div>
        </div>
    </main>

    <!-- This is the footer and is consistent across all pages. -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Fitness Class by Sarthak Gupta. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>