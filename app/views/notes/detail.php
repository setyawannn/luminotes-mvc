
    <?php if ($data['note']): ?>
        <div class="flex-grow">
            <div class="mt-4">
                <a href="<?= BASEURL ?>/dashboard" class="flex gap-x-2"><img src="<?= BASEURL ?>/img/icons/arrow-back.svg" alt="arrow-back">Back</a>
            </div>
            <div class="mt-8">
                <h1 class="text-2xl"><?= $data['note']['title'] ?></h1>
                <div class="flex justify-between items-center mt-6">
                    <div class="flex flex-col justify-start">
                        <div class="flex gap-x-3 items-center">
                            <img class="w-8 h-8 rounded-full object-cover" src="<?= BASEURL ?>/img/person/person1.png" alt="Person <?= $data['note']['creator']['name'] ?>">
                            <p><?= $data['note']['creator']['name'] ?></p>
                        </div>
                        <div class="mt-4 flex gap-x-6">
                            <div class="flex gap-x-3">
                                <img src="<?= BASEURL ?>/img/icons/star-filled.svg" alt="star-filled">
                                <p><?= $data['note']['rating'] ?></p>
                            </div>
                            <div class="flex gap-x-3">
                                <img src="<?= BASEURL ?>/img/icons/calendar-today.svg" alt="calendar-today">
                                <p><?= date('d M y', strtotime($data['note']['created_at'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <img src="<?= BASEURL ?>/img/icons/share.svg" alt="Share">
                        <p class="rounded-full text-sm border-2 p-1 mt-3 w-fit text-center"><?= $data['note']['category'] ?></p>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-y-3">
                <img src="<?= $data['note']['thumbnail'] ?>" alt="<?= $data['note']['title'] ?>" class="w-full">
                <p><?= $data['note']['description'] ?></p>
            </div>

            <div class="flex flex-col gap-y-2 mt-6">
                <div class="flex justify-between items-center">
                    <label for="file-preview" class="text-lg font-medium">File Preview</label>
                    <?php if (!empty($data['note']['file'])): ?>
                        <a href="<?= $data['note']['file'] ?>" download class="p-2 rounded border-2">
                            <img src="<?= BASEURL ?>/img/icons/download.svg" alt="Download">
                        </a>
                    <?php endif; ?>
                </div>
                <?php if (!empty($data['note']['file'])): ?>
                    <iframe src="<?= $data['note']['file'] ?>" frameborder="0" class="w-full h-[25rem] rounded mt-4"></iframe>
                <?php else: ?>
                    <div class="w-full h-96 flex items-center justify-center border-2 border-dashed rounded mt-4 text-gray-500">
                        No file preview available.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="w-full flex flex-col my-4 justify-center items-center">
            <button type="button" id="openModal" class="flex p-3 border-2 w-full rounded justify-center"><img src="<?= BASEURL ?>/img/icons/star-filled.svg" alt=""> Rate</button>
        </div>
        <!-- Modal Rating -->
        <div id="modal" class="fixed inset-0 backdrop-blur-sm bg-white/30 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full transform transition-transform duration-300 scale-95">
                <div class="w-full flex justify-end">
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-end">
                        <img src="<?= BASEURL ?>/img/icons/x.svg" alt="Close Modal">
                    </button>
                </div>
                <div class="flex justify-center items-center mb-4">
                    <h3 class="text-xl text-center font-medium">Rates</h3>
                </div>

                <div class="my-10">
                    <div class="flex justify-between" id="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <!-- Bintang rating interaktif -->
                            <img src="<?= BASEURL ?>/img/icons/star.svg" alt="Star" data-value="<?= $i ?>" class="star-icon cursor-pointer">
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="flex gap-x-4">
                    <button id="cancelButton" class="flex items-center justify-center w-full py-2 border-2 rounded text-black hover:bg-gray-100">Cancel</button>
                    <button id="submitRatingButton" class="w-full text-center py-2 bg-black text-white rounded">Submit</button>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center mt-20">
            <h1 class="text-2xl text-red-500">Catatan tidak ditemukan!</h1>
            <p class="mt-4">Mohon maaf, catatan yang Anda cari tidak ada.</p>
            <a href="<?= BASEURL ?>/home" class="mt-6 inline-block bg-blue-500 text-white py-2 px-4 rounded">Kembali ke Beranda</a>
        </div>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal');
            const modalContent = modal.querySelector('div');
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtn = document.getElementById('closeModal');
            const cancelButton = document.getElementById('cancelButton');
            const ratingStarsContainer = document.getElementById('rating-stars');
            const submitRatingButton = document.getElementById('submitRatingButton');
            let selectedRating = 0;

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
            cancelButton.addEventListener('click', closeModal);

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

            ratingStarsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('star-icon')) {
                    selectedRating = parseInt(event.target.dataset.value);
                    updateStars(selectedRating);
                }
            });

            function updateStars(rating) {
                Array.from(ratingStarsContainer.children).forEach((star, index) => {
                    if (index < rating) {
                        star.src = "<?= BASEURL ?>/img/icons/star-filled.svg"; 
                    } else {
                        star.src = "<?= BASEURL ?>/img/icons/star.svg"; 
                    }
                });
            }

            submitRatingButton.addEventListener('click', function() {
                console.log("Submit Rating:", selectedRating);
                fetch('<?= BASEURL ?>/api/submit-rating', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ note_id: <?= $data['note']['id'] ?? 'null' ?>, rating: selectedRating })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Rating submitted:', data);
                    closeModal();
                })
                .catch(error => console.error('Error submitting rating:', error));
                closeModal();
                showCustomNotification('Rating submitted: ' + selectedRating);
            });
        });
    </script>
</body>
</html>