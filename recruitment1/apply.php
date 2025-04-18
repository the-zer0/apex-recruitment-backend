<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply - Recruitment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(to right, #f1f8e9, #e3f2fd);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 800px;
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }

        label {
            font-weight: 500;
        }
    </style>

    <script>
        function showQuestion() {
            document.querySelectorAll('.domain-question').forEach(q => q.style.display = 'none');
            const selected = document.getElementById('domain').value;
            const target = document.getElementById(selected + '-question');
            if (target) target.style.display = 'block';
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Application Form</h2>
    <form action="submit_form.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Domain</label>
                <select name="domain" id="domain" class="form-select" onchange="showQuestion()" required>
                    <option value="">Select</option>
                    <option value="web">Web</option>
                    <option value="ml">Machine Learning</option>
                    <option value="cyber">Cybersecurity</option>
                </select>
            </div>
        </div>

        <!-- Web Questions -->
        <div id="web-question" class="domain-question" style="display:none;">
            <h5 class="mt-3">Web Development Questions</h5>
            <div class="mb-3"><label>1. Why are you interested in Web Development?</label><textarea name="question1" class="form-control"></textarea></div>
            <div class="mb-3"><label>2. What technologies have you used?</label><textarea name="question2" class="form-control"></textarea></div>
            <div class="mb-3"><label>3. Share a link to your past project (if any)</label><textarea name="question3" class="form-control"></textarea></div>
            <div class="mb-3"><label>4. What is responsive design?</label><textarea name="question4" class="form-control"></textarea></div>
            <div class="mb-3"><label>5. Are you comfortable working in a team?</label><textarea name="question5" class="form-control"></textarea></div>
        </div>

        <!-- Machine Learning Questions -->
        <div id="ml-question" class="domain-question" style="display:none;">
            <h5 class="mt-3">Machine Learning Questions</h5>
            <div class="mb-3"><label>1. What is your experience with ML?</label><textarea name="question1" class="form-control"></textarea></div>
            <div class="mb-3"><label>2. What ML frameworks are you familiar with?</label><textarea name="question2" class="form-control"></textarea></div>
            <div class="mb-3"><label>3. Describe a project you've worked on.</label><textarea name="question3" class="form-control"></textarea></div>
            <div class="mb-3"><label>4. What is overfitting and how do you prevent it?</label><textarea name="question4" class="form-control"></textarea></div>
            <div class="mb-3"><label>5. Favorite ML algorithm and why?</label><textarea name="question5" class="form-control"></textarea></div>
        </div>

        <!-- Cybersecurity Questions -->
        <div id="cyber-question" class="domain-question" style="display:none;">
            <h5 class="mt-3">Cybersecurity Questions</h5>
            <div class="mb-3"><label>1. Why are you interested in Cybersecurity?</label><textarea name="question1" class="form-control"></textarea></div>
            <div class="mb-3"><label>2. What is phishing and how can it be prevented?</label><textarea name="question2" class="form-control"></textarea></div>
            <div class="mb-3"><label>3. What tools have you used for penetration testing?</label><textarea name="question3" class="form-control"></textarea></div>
            <div class="mb-3"><label>4. Describe a security issue you've solved or researched.</label><textarea name="question4" class="form-control"></textarea></div>
            <div class="mb-3"><label>5. How do you stay up to date with security trends?</label><textarea name="question5" class="form-control"></textarea></div>
        </div>

        <div class="mb-4 mt-3">
    <label>Upload Resume (PDF only)</label>
    <input type="file" name="resume" accept=".pdf" class="form-control" required>
    <small class="text-danger">* Please rename the file with your name before uploading (e.g., JohnDoe_Resume.pdf) *</small>
</div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4 py-2">Submit Application</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function showQuestion() {
        document.querySelectorAll('.domain-question').forEach(q => {
            q.style.display = 'none';
            // Disable all textareas inside hidden domains
            q.querySelectorAll('textarea').forEach(t => t.disabled = true);
        });

        const selected = document.getElementById('domain').value;
        const target = document.getElementById(selected + '-question');
        if (target) {
            target.style.display = 'block';
            // Enable the active domain's fields
            target.querySelectorAll('textarea').forEach(t => t.disabled = false);
        }
    }

    // On page load, in case of validation error and refresh
    window.addEventListener('DOMContentLoaded', () => {
        showQuestion();
    });
</script>

</body>
</html>
