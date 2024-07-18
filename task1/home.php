<!DOCTYPE html>
<html>
<head>
    <title>Bug List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@2.0.1" integrity="sha384-QWGpdj554B4ETpJJC9z+ZHJcA/i59TyjxEPXiiUgN2WmTyV5OEZWCD6gQhgkdpB/" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Bug Tracker</h1>
        
        <!-- Bug List -->
        <div id="bugList" hx-get="/get_bugs.php" hx-trigger="every 5s" >
            <!-- Initial bug list loaded here -->
        </div>
        
        <!-- Modal -->
        <div id="bugModal" class="fixed inset-0 flex items-center justify-center hidden">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-bold mb-2">Bug Details</h2>

                
                <select id="bugStatus" class="border border-gray-300 rounded mb-2">
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
                <button hx-post="/updateBug.php" hx-target="#bugList" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                <button hx-trigger="close" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('htmx:afterSwap', function(event) {
            var bugs = event.detail.target.querySelectorAll('.bug');
            bugs.forEach(function(bug) {
                bug.addEventListener('click', function() {
                    document.getElementById('bugModal').classList.remove('hidden');
                });
            });
        });
        // document.getElementById('report').addEventListener('click', function() {
        //     var modal = document.getElementById('reportBugModal');
        //     modal.classList.toggle('hidden');
        //     document.getElementById('title').focus();
        // });

    </script>
</body>
</html>