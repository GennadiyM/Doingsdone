        <h2 class="content__main-heading">Регистрация аккаунта</h2>
          <form class="form" action="" method="post">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>
              <input class="form__input  <?php if(isset($tpl_data['errors']['email']) or isset($tpl_data['errors']
                      ['double_email']) or isset($tpl_data['errors']['invalid_email'])) : echo 'form__input--error';
              endif; ?>" type="text" name="email" id="email" value="<?=$tpl_data['values']['email']?>" placeholder="Введите e-mail">
              <?php if(isset($tpl_data['errors']['email'])) :?>
                <p class="form__message"><?=$tpl_data['errors']['email']?></p>
              <?php endif; ?>
                <?php if(isset($tpl_data['errors']['double_email'])) :?>
                    <p class="form__message"><?=$tpl_data['errors']['double_email']?></p>
                <?php endif; ?>
                <?php if(isset($tpl_data['errors']['invalid_email'])) :?>
                    <p class="form__message"><?=$tpl_data['errors']['invalid_email']?></p>
                <?php endif; ?>
            </div>

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>
              <input class="form__input <?php if(isset($tpl_data['errors']['password'])) : echo 'form__input--error';
              endif; ?>" type="password" name="password" id="password" placeholder="Введите пароль">
                <?php if(isset($tpl_data['errors']['password'])) :?>
                    <p class="form__message">Введите пароль</p>
                <?php endif; ?>
            </div>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>
              <input class="form__input <?php if(isset($tpl_data['errors']['name'])) : echo 'form__input--error';
              endif; ?>" type="text" name="name" id="name" value="<?=$tpl_data['values']['name']?>" placeholder="Введите имя">

                    <p class="form__message"> <?php if(isset($tpl_data['errors']['name'])) :?>
                <p class="form__message">Введите имя</p>
                <?php endif; ?></p>
            </div>

            <div class="form__row form__row--controls">
                <?php if(count($tpl_data['errors'])) :?>
                    <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
                <?php endif; ?>

              <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>
          </form>
