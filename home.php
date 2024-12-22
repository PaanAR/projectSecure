<?php include('db_connect.php') ?>

<!-- Display Welcome Message -->
<?php if ($_SESSION['login_type'] == 1): ?>
    <script>
        alert('Welcome, Administrator!');
    </script>

    <!-- Admin Dashboard -->
    <div class="row">
        <!-- Total Categories -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
                <a href="./index.php?page=categories">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Categories</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM categories")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Total Respondents -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <a href="./index.php?page=user_list">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Respondents</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM users WHERE type = 3")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Total Researchers -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <a href="./index.php?page=user_list">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Researchers</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM users WHERE type = 2")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Total Surveys -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>
                <a href="./index.php?page=survey_templates">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Surveys</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Total Messages -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-envelope"></i></span>
                <a href="./index.php?page=inbox">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Messages</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM contact")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

<?php elseif ($_SESSION['login_type'] == 2): ?>
    <script>
        alert('Welcome, Clerks!');
    </script>

    <!-- Researcher Dashboard -->
    <div class="row">
        <!-- Total Categories -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
                <!-- Displays a folder icon (fas fa-folder) to represent categories. -->
                <a href="./index.php?page=categories">
                  <!-- redirects the user to ./index.php?page=categories -->
                    <div class="info-box-content">
                        <span class="info-box-text">Total Categories</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM categories")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Total Templates -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>
                <a href="./index.php?page=survey_template">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Templates</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

<?php else: ?>
    <script>
        alert('Welcome, Respondent!');
    </script>

    <!-- Respondent Dashboard -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                Welcome <?php echo $_SESSION['login_name']; ?>!
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Surveys Taken -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>
                <a href="./index.php?page=survey_widget">
                    <div class="info-box-content">
                        <span class="info-box-text">Total Surveys Taken</span>
                        <span class="info-box-number">
                            <?php echo $conn->query("SELECT DISTINCT(survey_id) FROM answers WHERE user_id = {$_SESSION['login_id']}")->num_rows; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
