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
                <a href="#" class="nav-link">
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
        </ul>
      </nav>
    </div>
  </aside>
