<?php
// contact form template part

?>
<form action="">
    <div class="name_email_ar">
        <div class="name_ar">
            <input type="text" placeholder="Enter your name" name="name_ar" id="name_ar" required>
            <label for="name_ar">Name</label>
        </div>
        <div class="name_ar email_ar">
            <input type="email" placeholder="Enter your name" name="email_ar" id="email_ar" required>
            <label for="email_ar">Email</label>
        </div>
    </div>
    <div class="subject_ar">
        <input type="text" placeholder="Subject" name="subject_ar" id="subject_ar" required>
        <label for="subject_ar">Subject</label>
    </div>
    <div class="message_ar">
        <textarea name="message_ar" id="message_ar" cols="30" rows="10" placeholder="Message" required></textarea>
        <label for="message_ar">Message</label>
    </div>
    <div class="file_ar">
        <input type="file" name="file_ar" id="file_ar">
        <label for="file_ar">File</label>
    </div>
    <button type="submit">Send Message</button>
</form>