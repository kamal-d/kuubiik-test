<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hello World</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/htmx.org@2.0.1" integrity="sha384-QWGpdj554B4ETpJJC9z+ZHJcA/i59TyjxEPXiiUgN2WmTyV5OEZWCD6gQhgkdpB/" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="container mx-auto mt-8 flex flex-col items-center">
            <h1 class="text-4xl text-center">Hello World</h1>
            <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="report">Report a Bug</button>
        </div>

        <div id="reportBugModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg p-8 max-w-md">
                <h2 class="text-2xl font-bold mb-4">Report a Bug</h2>
                <form hx-post="/submit_bug.php" hx-target="#thankYouText">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-bold mb-2">Title:</label>
                        <input type="text" id="title" name="title" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 font-bold mb-2">Comment:</label>
                        <textarea id="comment" name="comment" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="urgency" class="block text-gray-700 font-bold mb-2">Urgency:</label>
                        <select id="urgency" name="urgency" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                        <button id="cancel" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="thankYouModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg p-8 max-w-md">
                <h2 class="text-2xl font-bold mb-4">Thank You</h2>
                <p class="text-lg">Your bug report has been submitted successfully. id <span id="thankYouText"></span></p>
            </div>
        </div>

        <script>
            document.getElementById('report').addEventListener('click', function() {
                var modal = document.getElementById('reportBugModal');
                modal.classList.toggle('hidden');
                document.getElementById('title').focus();
            });
            document.getElementById('cancel').addEventListener('click', function() {
                var modal = document.getElementById('reportBugModal');
                modal.classList.add('hidden');
            });
            document.addEventListener('htmx:afterSwap', function(event) {
                var modal = document.getElementById('reportBugModal');
                modal.classList.add('hidden');
                document.getElementById('thankYouModal').classList.remove('hidden');
    
                var htmxResponse = event.detail.xhr.responseText;
                console.log(htmxResponse);
                var existingBugs = JSON.parse(localStorage.getItem('bugs')) || [];
                existingBugs.push(htmxResponse);
                localStorage.setItem('bugs', JSON.stringify(existingBugs));
                if (event.detail.target.id === 'thankYouText') {
                    setTimeout(function() {
                        document.getElementById('thankYouModal').classList.add('hidden');
                    }, 3000);
                }
            });
        </script>
    </body>
</html>