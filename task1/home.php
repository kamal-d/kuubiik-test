<?php
require_once 'config.php';

if(!isset($accessToken)){
    header("Location: admin.php");
} else {
    require_once 'User.class.php'; 
    $user = new User();
    $gitUser = $gitClient->getAuthenticatedUser($accessToken);
    if(!empty($gitUser)){
        $gitUserData['oauth_uid'] = !empty($gitUser->id)?$gitUser->id:'';
        $gitUserData['oauth_provider'] = 'github'; 
        $userData = $user->checkUser($gitUserData);
        // var_dump($userData); die;
    } else {
        header("Location: admin.php");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Bug List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@2.0.1" integrity="sha384-QWGpdj554B4ETpJJC9z+ZHJcA/i59TyjxEPXiiUgN2WmTyV5OEZWCD6gQhgkdpB/" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container mx-auto w-full flex flex-col items-center">
        <h2 class="text-2xl font-bold mb-4 ">User Details</h2>
        <div class="ac-data">
            <div class="flex flex-wrap justify-center items-center">
            <img src="<?= $userData['picture']; ?>" class="mr-4 w-24 h-auto">
            <p class="mr-4"><b>Name:</b> <?= $userData['name']; ?></p>
            <p class="mr-4"><b>Profile Link:</b> <a href="<?= $userData['link']; ?>" target="_blank" class="text-blue-500">Click to visit GitHub page</a></p>
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-4">Bug List</h1>
        <!-- Bug List -->
        <div id="bugList" hx-get="/get_bugs.php" hx-trigger="every 3s" >
            <!-- Initial bug list loaded here -->
        </div>
        
        <!-- Modal -->
        <div id="bugModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-bold mb-2">Bug Details</h2>
                <form hx-post="/update_bug.php" hx-target="#bugId">
                    <input type="hidden" id="bugId" name="bugId">
                    <div class="mb-4">
                        <label for="bugTitle" class="block font-bold mb-2">Title</label>
                        <p id="bugTitle" class="border border-gray-300 rounded p-2"></p>
                    </div>
                    <div class="mb-4">
                        <label for="bugComment" class="block font-bold mb-2">Comment</label>
                        <p id="bugComment" class="border border-gray-300 rounded p-2"></p>
                    </div>
                    <div class="mb-4">
                        <label for="bugUrgency" class="block font-bold mb-2">Urgency</label>
                        <p id="bugUrgency" class="border border-gray-300 rounded p-2"></p>
                    </div>

                    <div class="mb-4">
                        <label for="bugStatus" class="block font-bold mb-2">Status</label>
                        <select id="bugStatus" class="border border-gray-300 rounded p-2" name="bugStatus">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="engComment" class="block font-bold mb-2">Add a Comment</label>
                        <input type="text" id="engComment" name="engComment" class="border border-gray-300 rounded p-2">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Save</button>
                        <button hx-trigger="close" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div id="thankYouModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-8 max-w-md">
            <h2 class="text-2xl font-bold mb-4">Thank You</h2>
            <p class="text-lg">Bug <span id="bugId"></span>updated successfully</span></p>
        </div>
    </div>
    <script>

        document.addEventListener('htmx:afterSwap', function(event) {
            if (event.detail.target.matches('#bugList')) {
                var bugs = event.detail.target.querySelectorAll('.bug');
                bugs.forEach(function(bug) {
                    bug.addEventListener('click', function() {
                        document.getElementById('bugModal').classList.remove('hidden');
                        document.getElementById('bugTitle').innerText = bug.getAttribute('data-title');
                        document.getElementById('bugComment').innerText = bug.getAttribute('data-comment');
                        document.getElementById('bugUrgency').innerText = bug.getAttribute('data-urgency');
                        document.getElementById('bugId').value = bug.getAttribute('data-id');
                    });
                });
            } else if (event.detail.target.id === 'bugId') {
                var modal = document.getElementById('bugModal');
                document.getElementById('bugTitle').innerText = "";
                document.getElementById('bugComment').innerText = "";
                document.getElementById('bugUrgency').innerText = "";
                document.getElementById('bugId').value = "";
                modal.classList.add('hidden');
                document.getElementById('thankYouModal').classList.remove('hidden');
                setTimeout(function() {
                    document.getElementById('thankYouModal').classList.add('hidden');
                }, 3000);
            }
        });

    </script>
</body>
</html>