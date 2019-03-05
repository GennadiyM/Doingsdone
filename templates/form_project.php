        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="" method="post">
          <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="title" id="project_name" value="" placeholder="Введите название проекта">
          </div>
            <?php if (!empty($errors)): ?>
                <p class="form__message">
                    <?=$errors?>
                </p>
            <?php endif; ?>
          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>


