<div class="flex justify-between items-center mt-4">
      <h3 class="text-2xl">Home</h3>
      <a href="<?= BASEURL; ?>/profile" class="p-2 border-2 rounded">
        <img src="<?= BASEURL; ?>/img/icons/person.svg" alt="Person">
      </a>
    </div>
    <div class="flex gap-x-2 mt-4">
      <button type="button" id="openModal" class="p-2 border-2 rounded">
        <img src="<?= BASEURL; ?>/img/icons/tune.svg" alt="Filter">
      </button>
      <div class="p-2 border-2 rounded w-full">
        <input type="text" placeholder="Search">
      </div>
    </div>
    <div class="mt-6 flex flex-col gap-y-12">
      <?php foreach($data['notes'] as $note): ?>
      <a href="<?= BASEURL; ?>/dashboard/notes/detail/<?= $note['id']; ?>">
        <div class="flex gap-x-3 items-center">
          <img class="w-8 h-8 rounded-full object-cover" src="<?= BASEURL?>/img/person/person1.png" alt="<?= $note['creator']['name']; ?>">
          <p><?= $note['creator']['name']; ?></p>
        </div>
        <div class="flex justify-between gap-x-4">
          <div class="w-2/3">
            <h2 class="font-medium text-xl"><?= $note['title']; ?></h2>
            <p><?= $note['description']; ?></p>
          </div>
          <div class="w-1/3">
            <img src="<?= $note['thumbnail']; ?>" alt="<?= $note['category']; ?>">
            <p class="rounded-full text-sm border-2 p-1 mt-3 w-fit text-center"><?= $note['category']; ?></p>
          </div>
        </div>
        <div class="mt-4 flex gap-x-6">
          <div class="flex gap-x-3">
            <img src="<?= BASEURL; ?>/img/icons/star-filled.svg" alt="star-filled">
            <p><?= $note['rating']; ?></p>
          </div>
          <div class="flex gap-x-3">
            <img src="<?= BASEURL; ?>/img/icons/calendar-today.svg" alt="calendar-today">
            <p><?= $note['created_at']; ?></p>
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <a href="<?= BASEURL; ?>/notes/add" class="fixed bottom-8 right-8 border-2 p-2 rounded">
      <img src="<?= BASEURL; ?>/img/icons/add.svg" alt="Add Note">
    </a>
    <div id="modal"
      class="fixed inset-0 backdrop-blur-sm bg-white/30 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0">
      <div
        class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full transform transition-transform duration-300 scale-95">
        <div class="w-full flex justify-end">
          <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-end">
            <img src="<?= BASEURL; ?>/img/icons/x.svg" alt="Close Modal">
          </button>
        </div>
        <div class="flex justify-center items-center mb-4">
          <h3 class="text-xl text-center font-medium">Filters</h3>
        </div>

        <div class="mb-4">
          <div class="flex flex-col gap-y-4">
            <div class="flex flex-col gap-y-2">
              <label for="topic">Topic</label>
              <select class="p-2 border w-full rounded">
                <option value="">Select topic</option>
                <option value="pemrograman">Pemrograman</option>
                <option value="science">Science</option>
                <option value="desain">Desain</option>
              </select>
            </div>
            <div class="flex flex-col gap-y-2">
              <label for="Date">Start Date</label>
              <input type="date" placeholder="Start Date" class="p-2 border w-full rounded">
              <label for="Date">End Date</label>
              <input type="date" placeholder="End Date" class="p-2 border w-full rounded">
            </div>
            <div class="flex flex-col gap-y-2">
              <label for="Date">Date</label>
              <div class="flex items-center gap-x-2">
                <select class="p-2 border w-1/3 rounded">
                  <option value="">Operator</option>
                  <option value="<">
                    < </option>
                  <option value="<=">
                    <= </option>
                  <option value="=="> == </option>
                  <option value="!="> != </option>
                  <option value=">="> >= </option>
                  <option value=">"> > </option>
                </select>
                <input type="number" placeholder="Rating 0 - 5" class="p-2 border w-2/3 rounded">
              </div>
            </div>
          </div>
        </div>
        <div class="flex gap-x-4">
          <button id="cancelButton"
            class="flex items-center justify-center w-full py-2 border-2 rounded text-black hover:bg-gray-100"><img
              src="<?= BASEURL; ?>/img/icons/filter-off.svg" alt="Filter Off">Clear</button>
          <a href="<?= BASEURL; ?>/dashboard" id="confirmButton" class="w-full text-center py-2 bg-black text-white rounded">Apply</a>
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
    