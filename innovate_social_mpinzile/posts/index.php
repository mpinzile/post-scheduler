<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles for the header */
            /* Style the header */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #3498db; /* Updated header color */
            color: #fff;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow */
            z-index: 1000;
        }

        /* Style the header title */
        .header-title {
            font-size: 32px;
            margin: 0;
        }

        /* Style the header subtitle */
        .header-subtitle {
            font-size: 18px;
            margin: 10px 0;
        }
        .content {
            padding-top: 60px; /* Adjust this value to provide spacing below the fixed header */
            margin-top: 20px;
        }

        /* Style the scrollbar */
        #postContainer {
        max-height: 500px; /* Adjust the max height to your preference */
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #007bff #f1f1f1;
        }

        #postContainer::-webkit-scrollbar {
            width: 8px;
        }

        #postContainer::-webkit-scrollbar-thumb {
            background-color: #E74C3C;
            border-radius: 4px; /* Rounded corners for the scrollbar thumb */
        }

        #postContainer::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 4px; /* Rounded corners for the scrollbar track */
        }
        .card-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            color:#E74C3C;
        }
    </style>
</head>
<body>
<!-- Header Section -->
<header class="fixed-header">
    <!-- <h1 class="display-5">InnovateSocial</h1> -->
    <p class="lead">Discover interesting posts from our community.</p>
</header>
<div class="container mt-5 content">
    <div class="row" id="postContainer">
        <!-- Posts will be dynamically added here -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script> <!-- Include jQuery Migrate for compatibility -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Function to fetch and update posts
    function fetchPosts() {
        $.ajax({
            url: 'fetch_posts.php', // Replace with your PHP script URL
            method: 'GET',
            success: function(data) {
                $('#postContainer').html(data); // Update the content with fetched data
            },
            complete: function() {
                setTimeout(fetchPosts, 1000); // Refresh every 1 second
            }
        });
    }

    // Initial call to start fetching posts
    fetchPosts();
</script>

</body>
</html>
