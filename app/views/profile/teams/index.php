    
    <div class="mt-4 flex justify-between items-center">
      <a href="<?= BASEURL . '/profile' ?>" class="flex gap-x-2"><img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back">
        <h3 class="text-3xl">Teams</h3>
      </a>
      <a href="<?= BASEURL . '/teams/create' ?>" class="p-2 rounded border-2"><img src="<?= BASEURL; ?>/img/icons/add.svg" alt="Add"></a>
    </div>
    <div class="mt-4">
      <div class="mt-4">
        <ul class="flex gap-x-4 text-lg border-b-1">
          <li class="border-b-2">All</li>
          <li>Owned</li>
          <li>Joined</li>
        </ul>
      </div>
      <div class="mt-4">
        <form action="<?= BASEURL; ?>/teams/processJoin" method="POST" class="flex justify-center items-center gap-x-4">
            <input type="text" name="team_code" placeholder="Team Code" class="p-2 border-2 w-full rounded">
            <button type="submit" class="px-4 py-2 rounded border-2">Join</button>
        </form>
      </div>
      <div class="grid grid-cols-2 mt-6 gap-4">
        <?php foreach($data['teams'] as $team) : ?>
            <a href="<?= BASEURL . '/teams/detail/' . $team['id'] ?>" class="col-span-1 rounded border-2 w-full h-16 flex justify-center items-center">
                <h4><?= $team['name'] ?></h4>
            </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>