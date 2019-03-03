
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>
                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/?time=<?=$request_by_time['all'];?>" class="tasks-switch__item
                        <?php if (isset($_GET['time']) && $_GET['time'] == 'all' || !isset($_GET['time'])) :
                            echo "tasks-switch__item--active";
                        endif;?>">Все задачи</a>
                        <a href="/?time=<?=$request_by_time['today'];?>" class="tasks-switch__item
                        <?php if (isset($_GET['time']) && $_GET['time'] == 'today') :
                            echo "tasks-switch__item--active";
                        endif;?>">Повестка дня</a>
                        <a href="/?time=<?=$request_by_time['tomorrow'];?>" class="tasks-switch__item
                        <?php if (isset($_GET['time']) && $_GET['time'] == 'tomorrow') :
                            echo "tasks-switch__item--active";
                        endif;?>">Завтра</a>
                        <a href="/?time=<?=$request_by_time['overdue'];?>" class="tasks-switch__item
                        <?php if (isset($_GET['time']) && $_GET['time'] == 'overdue') :
                            echo "tasks-switch__item--active";
                        endif;?>">Просроченные</a>
                    </nav>
                    <?php if (isset($_GET['cat']) && $_GET['cat'] == $categories_item['id']) :
                        echo "main-navigation__list-item--active";
                    endif;?>
                    <label class="checkbox">
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                            <?php if ($show_complete_tasks == 1) : echo "checked";
                            endif; ?>
                        >
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach($task_list as $item) :
                        if ($show_complete_tasks == 0 and $item['status'] == '1') : continue;
                        endif; ?>
                        <tr class="tasks__item task <?php if (check_burning_tasks($item['dt_doing'], $time_limit)) : echo $class_of_burning_tasks;
                        endif; ?>">
                            <td class="task__select">
                                <label class="checkbox task__checkbox">
                                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$item['id'];?>"
                                        <?php if ($item['status'] == '1') : echo "checked";
                                        endif; ?>
                                    >
                                    <span class="checkbox__text"><?=esc($item['name_task'])?></span>
                                </label>
                            </td>
                            <td class="task__file">
                                <?php if (isset($item['path'])): ?>
                                    <a class="download-link" href="<?=$item['path']?>"><?="Файл задачи"?></a>
                                <?php endif; ?>
                            </td>
                            <td class="task__date"><?=esc(date_arr_in_date_str($item['dt_doing']))?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

