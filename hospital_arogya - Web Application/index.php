<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container-fluid p-0">
    <!-- Background Image with Blur Effect and Increased Opacity -->
    <div class="bg-image">
        <img src="images/bg.jpg" class="img-fluid" alt="Background Image">
    </div>

    <!-- Content Over Background Image -->
    <div class="content-container">
        <!-- Welcome Section -->
        <div class="jumbotron mb-5">
            <h1 class="display-4">Welcome to Arogya Health Care</h1>
            <p class="lead">"At Arogya Health Care, your health and well-being reign supreme. With unwavering dedication, we strive to deliver superior medical services that enrich the lives of our community."</p>
            <hr class="my-4">
            <p>Our state-of-the-art facilities and highly trained staff are here to ensure that you receive the best care possible. Explore our services and find out how we can help you maintain a healthy lifestyle.</p>
        </div>

        <div class="row mt-5">
    <h2>Rehabilitation Services</h2>
    <div class="col-md-4">
        <div class="card">
            <img src="images/rehabilitation1.jpg" class="card-img-top" alt="Rehabilitation 1">
            <div class="card-body">
                <h5 class="card-title">Physical Therapy</h5>
                <p class="card-text">Tailored physical therapy programs to aid recovery and improve mobility.</p>
                <a href="#" class="btn btn-primary">Learn More</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <img src="images/rehabilitation2.jpg" class="card-img-top" alt="Rehabilitation 2">
            <div class="card-body">
                <h5 class="card-title">Occupational Therapy</h5>
                <p class="card-text">Specialized therapy to assist in regaining daily life skills and independence.</p>
                <a href="#" class="btn btn-primary">Learn More</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <img src="images/rehabilitation3.jpg" class="card-img-top" alt="Rehabilitation 3">
            <div class="card-body">
                <h5 class="card-title">Speech Therapy</h5>
                <p class="card-text">Individualized therapy sessions to improve speech and communication abilities.</p>
                <a href="#" class="btn btn-primary">Learn More</a>
            </div>
        </div>
    </div>
</div>

        <!-- About Section -->
        <div class="row mt-5">
            <div class="col-md-6">
                <h2>About Arogya Health Care</h2>
                <br>
                <p>

                At Arogya Health Care, we pride ourselves on our commitment to excellence in healthcare. Our expert team comprises leading specialists and dedicated healthcare professionals who are passionate about your well-being. Utilizing cutting-edge medical technology and advanced treatment protocols, we ensure precise diagnoses and effective treatments. With a patient-centered approach, we prioritize your needs and preferences, offering personalized treatment plans and compassionate support. From comprehensive preventive care to intricate surgeries, we provide a full spectrum of healthcare services, all conveniently accessible under one roof.</p>
            </div>
            <div class="col-md-6">
                <img src="images/about.png" class="img-fluid rounded" alt="About Us Image">
            </div>
        </div>

        <!-- Doctors Section -->
        <div class="row mt-5">
            <h2>Meet Our Doctors</h2>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/doctor1.jpg" class="card-img-top" alt="Doctor 1">
                    <div class="card-body">
                        <h5 class="card-title">Dr. Jennifer Tristan</h5>
                        <p class="card-text">Specialist in Cardiology</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/doctor2.jpg" class="card-img-top" alt="Doctor 2">
                    <div class="card-body">
                        <h5 class="card-title">Dr. Jane Smith</h5>
                        <p class="card-text">Specialist in Neurology</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/doctor3.jpg" class="card-img-top" alt="Doctor 3">
                    <div class="card-body">
                        <h5 class="card-title">Dr. Sam Brown</h5>
                        <p class="card-text">Specialist in Orthopedics</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Number Counters Section -->
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card text-center py-4">
                    <span id="patientCount" class="counter-value text-primary">100</span>
                    <p class="counter-label">Total Patients</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center py-4">
                    <span id="roomCount" class="counter-value text-success">10</span>
                    <p class="counter-label">Total Rooms Available</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center py-4">
                    <span id="staffCount" class="counter-value text-danger">30</span>
                    <p class="counter-label">Total Staff Members</p>
                </div>
            </div>
        </div>

        <!-- News and Updates Section -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card h-100">
                    <img src="images/news1.jpg" class="card-img-top" alt="New Wing Opening">
                    <div class="card-body">
                        <h5 class="card-title">New Wing Opening</h5>
                        <p class="card-text">We are excited to announce the opening of our new wing dedicated to pediatric care.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <img src="images/news2.jpg" class="card-img-top" alt="Health Awareness Camp">
                    <div class="card-body">
                        <h5 class="card-title">Health Awareness Camp</h5>
                        <p class="card-text">Join us for our annual health awareness camp and get free health check-ups and consultations.</p>
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-dark text-light text-center py-2">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Arogya Health Care Hospital</p>
            <p class="mb-0">Copyright © 2012 - 2024 Apex Design Works®. All rights reserved. <i class="bi bi-heart-fill text-danger"></i></p>
        </div>
    </footer>
</div>

<!-- CSS -->
<style>
    body, html {
        height: 100%;
        margin: 0;
        overflow-x: hidden;
    }
    .bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
        filter: blur(8px);
        opacity: 0.8; /* Increased opacity for the background image */
    }
    .bg-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .content-container {
        position: relative;
        z-index: 1;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px; /* Push down the content */
        margin-bottom: 50px; /* Add space for the footer */
    }
    .jumbotron {
        background-color: rgba(255, 255, 255, 0.7);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .card {
        margin-bottom: 20px;
    }
    .counter-value {
        font-size: 3rem; /* Adjust font size for counters */
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
    }
    .counter-label {
        font-size: 1.5rem; /* Adjust font size for counter labels */
        margin-bottom: 0;
    }
    .card-img-top {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        max-height: 200px; /* Limit image height */
        object-fit: cover; /* Ensure images cover the entire card */
    }
    .jumbotron h1, .jumbotron p {
        color: #333; /* Adjust text color for better readability */
    }
    .jumbotron hr {
        border-top-color: #333; /* Adjust color of the hr element */
        width: 50%; /* Adjust width of the hr element */
    }
</style>



</body>
</html>
