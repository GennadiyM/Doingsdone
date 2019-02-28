
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="/" class="tasks-switch__item">Повестка дня</a>
                        <a href="/" class="tasks-switch__item">Завтра</a>
                        <a href="/" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                            <?php if ($show_complete_tasks == 1) : echo "checked";
                            endif; ?>
                        >
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach($task_list as $item) :
                        if ($show_complete_tasks == 0 and $item['status'] == 'Да') : continue;
                        endif; ?>
                        <tr class="tasks__item task <?php if (check_burning_tasks($item['date'], $time_limit)) : echo $class_of_burning_tasks;
                        endif; ?>">
                            <td class="task__select">
                                <label class="checkbox task__checkbox">
                                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1"
                                        <?php if ($item['status'] == 'Да') : echo "checked";
                                        endif; ?>
                                    >
                                    <span class="checkbox__text"><?=esc($item['task'])?></span>
                                </label>
                            </td>

                            <!--                        <td class="task__file">-->
                            <!--                            <a class="download-link" href="#">Home.psd</a>-->
                            <!--                        </td>-->

                            <td class="task__date"><?=esc($item['date'])?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

