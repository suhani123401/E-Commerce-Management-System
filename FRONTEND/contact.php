<?php
include('../connection1.php'); // database connection
include('include/header.php');

if(isset($_POST['submit'])){
    // Get form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare the SQL statement
    $stmt = $conns->prepare("INSERT INTO contact(name, email, message) VALUES (?, ?, ?)");
    if($stmt === false){
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters (s = string)
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement
    if($stmt->execute()){
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>



    <style>
        #contact-form {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }
    </style>



    <!--Contact Page-->

    <section class="my-5 py-5">
        <div class="container">
            <!-- Title -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">Contact Us</h2>
                <hr class="mx-auto" style="width:50px; border:2px solid #007bff;">
                <p>Send us a message and we will get back to you soon.</p>
            </div>

            <!-- Contact Form -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form id="contact-form" method="POST">
                        <div class="mb-3">
                            <label for="contact-name" class="form-label fw-bold">Name</label>
                            <input type="text" class="form-control" id="contact-name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact-email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="contact-email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact-message" class="form-label fw-bold">Message</label>
                            <textarea class="form-control" id="contact-message" rows="5" name="message" placeholder="Type your message..." required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--Contact Page-->



 
<?php include('include/footer.php'); ?>