    
    <div class="mt-4 flex justify-between items-center">
      <a href="<?= BASEURL . '/profile' ?>" class="flex gap-x-2"><img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back">
        <h3 class="text-3xl">Teams</h3>
      </a>
      <button type="button" id="openModal" class="p-2 rounded border-2"><img src="<?= BASEURL; ?>/img/icons/add.svg" alt="Add"></button>
    </div>
    <div class="mt-4">
      <div class="mt-4">
        <ul class="flex gap-x-4 text-lg border-b-1">
          <li class="border-b-2">All</li>
          <li>Owned</li>
          <li>Joined</li>
        </ul>
      </div>
      <div class="mt-4 flex justify-center items-center gap-x-4">
        <input type="text" placeholder="Team Code" class="p-2 border-2 w-full rounded">
        <button class="px-4 py-2 rounded border-2">Join</button>
      </div>
      <div class="grid grid-cols-2 mt-6 gap-4">
        <?php foreach($data['teams'] as $team) : ?>
            <a href="<?= BASEURL . '/teams/detail/' . $team['id'] ?>" class="col-span-1 rounded border-2 w-full h-16 flex justify-center items-center">
                <h4><?= $team['name'] ?></h4>
            </a>
        <?php endforeach; ?>
      </div>
    </div>
    
    <div id="modal" class="fixed inset-0 backdrop-blur-sm bg-white/30 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full transform transition-transform duration-300 scale-95">
            <div class="w-full flex justify-end">
                <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-end">
                    <img src="<?= BASEURL; ?>/img/icons/x.svg" alt="Close Modal">
                </button>
            </div>
            <div class="flex justify-center items-center mb-4">
                <h3 class="text-xl text-center font-medium">Add Team</h3>
            </div>
            <div class="mb-4">
                <div class="flex flex-col gap-y-4">
                    <input type="text" placeholder="Title" class="p-2 border w-full rounded">
                    <textarea class="p-2 border w-full rounded">Description</textarea>
                </div>
            </div>
            <div class="flex gap-x-4">
                <button id="cancelButton" class="w-full py-2 border-2 rounded text-black hover:bg-gray-100">Cancel</button>
                <a href="team-detail.html" id="confirmButton" class="w-full text-center py-2 bg-black text-white rounded">Confirm</a>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modal = document.getElementById('modal');
      const modalContent = modal.querySelector('div');
      const openModalBtn = document.getElementById('openModal');
      const closeModalBtn = document.getElementById('closeModal');
      const cancelBtn = document.getElementById('cancelButton');

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
      cancelBtn.addEventListener('click', closeModal);

      modal.addEventListener('click', function (e) {
        if (e.target === modal) {
          closeModal();
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeModal();
        }
      });
    });
  </script>