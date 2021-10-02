<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed">
    <a href="/bots-panel/" class="brand-link text-center">
      <span class="brand-text font-weight-light"><b>GS</b> Tasting Platform</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?=$_SESSION['userLogin']?></a>
        </div>
      </div>

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Поиск" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

					<li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Тесты
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#AddTest" data-toggle="modal" class="nav-link">
                  <i class="far fa-circle text-success nav-icon"></i>
                  <p>Создать тест</p>
                </a>
              </li>
                <?
                $tests = $Database->GetTests($_SESSION['userId']);
                for($i = 0; $i < Count($tests); $i++):
                ?>

              <li class="nav-item ml-2">
                <a href="/bots-panel/pages/test.php?IdTest=<?=$tests[$i]['Id']?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p><?=$tests[$i]['Name']?></p>
                </a>
              </li>
              <?endfor;?>
            </ul>
          </li>
					<li class="nav-item">
            <a href="/bots-panel/pages/results.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Результаты тестов</p>
            </a>
          </li>
					<li class="nav-item">
            <a href="/bots-panel/pages/bots_vk.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>ВК боты</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

	<div class="modal fade" id="AddTest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
							<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Добавить тест</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
							</div>
							<div class="modal-body">
									<form action="actions/action_tests.php?method=add" method="post">
											<div class="md-form mt-4" style="display: none">
													<label for="IdUserPanel">id</label>
													<input type="text" id="IdUserPanel" class="form-control" name="IdUserPanel" value="<?=$_SESSION['userId']?>" maxlength="20">
											</div>
											<div class="md-form mt-4">
													<label for="Name">Наименование (для удобства)</label>
													<input type="text" id="Name"  class="form-control" name="Name" maxlength="200">
											</div>
											<div class="text-center mt-4 d-flex justify-content-center">
													<button type="submit" class="btn btn-primary btn-block btn-rounded z-depth-1a" style="width: 40%;height: 50px;border-radius: 34px">Добавить</button>
											</div>
									</form>
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
							</div>
					</div>
			</div>
	</div>

