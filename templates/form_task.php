<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form"  action="" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?php if (isset($errors['name'])): echo "form__input--error"; endif; ?>" type="text" name="name" id="name" value="" placeholder="Введите название">
        <?php if (isset($errors)): ?>
            <p class="form__message">
                <?=$errors['name']?>
            </p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select" name="project" id="project">
            <?php foreach ($categories as $value) : ?>
                <option value="<?=$value['id']?>"><?=$value['title']?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date" type="date" name="date" id="date" value="" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    </div>

    <div class="form__row">
        <label class="form__label" for="preview">Файл</label>

        <div class="form__input-file <?php if (isset($errors['file'])): echo "form__input--error"; endif; ?>">
            <input class="visually-hidden" type="file" name="doc" id="preview" value="">
            <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
            </label>
            <?php if (isset($errors)): ?>
                <p class="form__message">
                    <?=$errors['file']?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
<?php if (count($errors)): ?>
    <p class="form__message">
        <?="Пожалуйста, исправьте ошибки в форме"?>
    </p>
<?php endif; ?>