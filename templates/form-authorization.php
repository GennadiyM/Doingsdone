        <h2 class="content__main-heading">Вход на сайт</h2>
        <form class="form" action="" method="post">
          <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>
              <input class="form__input  <?php if(isset($tpl_data['errors']['email'])) : echo 'form__input--error'; endif; ?>"
                     type="text" name="email" id="email" value="<?=$tpl_data['values']['email']?>" placeholder="Введите e-mail">
              <?php if(isset($tpl_data['errors']['email'])) :?>
                  <p class="form__message"><?=$tpl_data['errors']['email']?></p>
              <?php endif; ?>
              <?php if(isset($tpl_data['errors']['invalid_email'])) :?>
                  <p class="form__message"><?=$tpl_data['errors']['invalid_email']?></p>
              <?php endif; ?>
              <?php if(isset($tpl_data['errors']['double_email'])) :?>
                  <p class="form__message"><?=$tpl_data['errors']['double_email']?></p>
              <?php endif; ?>
          </div>

          <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>
              <input class="form__input <?php if(isset($tpl_data['errors']['password'])) : echo 'form__input--error';
              endif; ?>" type="password" name="password" id="password" placeholder="Введите пароль">
              <?php if(isset($tpl_data['errors']['password'])) :?>
                  <p class="form__message">Введите пароль</p>
              <?php endif; ?>
              <?php if(isset($tpl_data['errors']['password_error'])) :?>
                  <p class="form__message">Неверный пароль. Попробуйте еще раз</p>
              <?php endif; ?>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
          </div>
        </form>
