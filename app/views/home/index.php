<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= BASEURL ?>/css/tailwind.css" rel="stylesheet">
    <link href="<?= BASEURL ?>/css/style.css" rel="stylesheet">
    <link href="<?= BASEURL ?>/css/index.css" rel="stylesheet">
</head>
<body>
    <div class="font-primary max-w-xs mx-auto w-full min-h-screen flex flex-col p-4">
        <div class="flex justify-between items-center mt-4">
            <h3 class="text-2xl">Home</h3>
            <a href="<?= BASEURL ?>/profile" class="p-2 border-2 rounded">
                <img src="<?= BASEURL ?>/img/icons/person.svg" alt="Person">
            </a>
        </div>
        <div class="flex gap-x-2 mt-4">
            <button type="button" id="openModal" class="p-2 border-2 rounded">
                <img src="<?= BASEURL ?>/img/icons/tune.svg" alt="Filter">
            </button>
            <div class="p-2 border-2 rounded w-full">
                <input type="text" placeholder="Search" id="search-input" value="<?= $_GET['search'] ?? '' ?>">
            </div>
        </div>

        <?php Flasher::flash(); ?> <!-- Menampilkan flash message -->

        <div class="mt-6 flex flex-col gap-y-12">
            <?php if (empty($data['notes'])): ?>
                <p class="text-center text-gray-500">Tidak ada catatan ditemukan.</p>
            <?php else: ?>
                <?php foreach ($data['notes'] as $note): ?>
                    <a href="<?= BASEURL ?>/notes/detail/<?= $note['id'] ?>">
                        <div class="flex gap-x-3 items-center">
                            <img class="w-8 h-8 rounded-full object-cover" src="<?= BASEURL ?>/img/person/<?= $note['creator']['img'] ?>" alt="Person <?= $note['creator']['name'] ?>">
                            <p><?= $note['creator']['name'] ?></p>
                        </div>
                        <div class="flex justify-between gap-x-4">
                            <div class="w-2/3">
                                <h2 class="font-medium text-xl"><?= $note['title'] ?></h2>
                                <p><?= $note['description'] ?></p>
                            </div>
                            <div class="w-1/3">
                                <img src="<?= BASEURL ?>/img/thubmnail/<?= $note['thumbnail'] ?>" alt="<?= $note['title'] ?>">
                                <p class="rounded-full text-sm border-2 p-1 mt-3 w-fit text-center"><?= $note['category'] ?></p>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-x-6">
                            <div class="flex gap-x-3">
                                <img src="<?= BASEURL ?>/img/icons/star-filled.svg" alt="star-filled">
                                <p><?= $note['rating'] ?></p>
                            </div>
                            <div class="flex gap-x-3">
                                <img src="<?= BASEURL ?>/img/icons/calendar-today.svg" alt="calendar-today">
                                <p><?= date('d M y', strtotime($note['created_at'])) ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <a href="<?= BASEURL ?>/notes/add" class="fixed bottom-8 right-8 border-2 p-2 rounded-full bg-white">
            <img src="<?= BASEURL ?>/img/icons/add.svg" alt="Add Note" class="w-6 h-6">
        </a>
        <div id="modal" class="fixed inset-0 backdrop-blur-sm bg-white/30 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full transform transition-transform duration-300 scale-95">
                <div class="w-full flex justify-end">
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-end">
                        <img src="<?= BASEURL ?>/img/icons/x.svg" alt="Close Modal">
                    </button>
                </div>
                <div class="flex justify-center items-center mb-4">
                    <h3 class="text-xl text-center font-medium">Filters</h3>
                </div>

                <form id="filter-form" method="GET" action="<?= BASEURL ?>/home">
                    <div class="mb-4">
                        <div class="flex flex-col gap-y-4">
                            <div class="flex flex-col gap-y-2">
                                <label for="topic">Topic</label>
                                <select name="topic" id="topic" class="p-2 border w-full rounded">
                                    <option value="">Select topic</option>
                                    <option value="Pemrograman" <?= (($_GET['topic'] ?? '') == 'Pemrograman') ? 'selected' : '' ?>>Pemrograman</option>
                                    <option value="Matematika" <?= (($_GET['topic'] ?? '') == 'Matematika') ? 'selected' : '' ?>>Matematika</option>
                                    <option value="Science" <?= (($_GET['topic'] ?? '') == 'Science') ? 'selected' : '' ?>>Science</option>
                                    <option value="Desain" <?= (($_GET['topic'] ?? '') == 'Desain') ? 'selected' : '' ?>>Desain</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-y-2">
                                <label for="start_date">Start Date</label>
                                <input type="date" name="start_date" id="start_date" placeholder="Start Date" class="p-2 border w-full rounded" value="<?= $_GET['start_date'] ?? '' ?>">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" placeholder="End Date" class="p-2 border w-full rounded" value="<?= $_GET['end_date'] ?? '' ?>">
                            </div>
                            <div class="flex flex-col gap-y-2">
                                <label for="rating_val">Rating</label>
                                <div class="flex items-center gap-x-2">
                                    <select name="rating_op" id="rating_op" class="p-2 border w-1/3 rounded">
                                        <option value="">Operator</option>
                                        <option value="<" <?= (($_GET['rating_op'] ?? '') == '<') ? 'selected' : '' ?>> < </option>
                                        <option value="<=" <?= (($_GET['rating_op'] ?? '') == '<=') ? 'selected' : '' ?>> <= </option>
                                        <option value="==" <?= (($_GET['rating_op'] ?? '') == '==') ? 'selected' : '' ?>> == </option>
                                        <option value="!=" <?= (($_GET['rating_op'] ?? '') == '!=') ? 'selected' : '' ?>> != </option>
                                        <option value=">=" <?= (($_GET['rating_op'] ?? '') == '>=') ? 'selected' : '' ?>> >= </option>
                                        <option value=">" <?= (($_GET['rating_op'] ?? '') == '>') ? 'selected' : '' ?>> > </option>
                                    </select>
                                    <input type="number" name="rating_val" id="rating_val" placeholder="Rating 0 - 5" class="p-2 border w-2/3 rounded" min="0" max="5" step="0.1" value="<?= $_GET['rating_val'] ?? '' ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-x-4">
                        <button type="button" id="clearButton" class="flex items-center justify-center w-full py-2 border-2 rounded text-black hover:bg-gray-100"><img src="<?= BASEURL ?>/img/icons/filter-off.svg" alt="Filter Off" class="w-5 h-5 mr-1">Clear</button>
                        <button type="submit" id="applyButton" class="w-full text-center py-2 bg-black text-white rounded">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal');
            const modalContent = modal.querySelector('div');
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtn = document.getElementById('closeModal');
            const clearButton = document.getElementById('clearButton');
            const searchInput = document.getElementById('search-input');
            const filterForm = document.getElementById('filter-form');

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                void modal.offsetWidth; 
                modal.classList.add('opacity-100');
                modal.classList.remove('opacity-0');
                modalContent.classList.add('scale-100');
                modalContent.classList.remove('scale-95');
            }

            function closeModal() {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300); 
            }

            openModalBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);

            // Handle clear button click
            clearButton.addEventListener('click', function() {
                // Reset all form fields
                filterForm.querySelectorAll('select, input[type="date"], input[type="number"]').forEach(field => {
                    if (field.type === 'select-one') {
                        field.value = '';
                    } else if (field.type === 'date') {
                        field.value = '';
                    } else if (field.type === 'number') {
                        field.value = '';
                    }
                });
                // Submit the form to clear filters from URL
                filterForm.submit();
            });

            // Handle search input Enter key
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('search', searchInput.value);
                    window.location.href = currentUrl.toString();
                }
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>