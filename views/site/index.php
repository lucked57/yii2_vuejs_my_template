<?php

/* @var $this yii\web\View */
$id = '5';
//$this->title = 'Main';
?>






    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-5 pt-md-3 pb-2 mb-3 border-bottom mt-5">
        <h1 class="h2 mt-md-0 mt-5">Панель управления</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary me-2">Поделиться</button>
           <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Экспорт</button>-->
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            Текущая неделя
          </button>
        </div>
      </div>

       <div id="piechart" style="width: 100%; height: 500px;"></div>
       
       <!--<input class="form-control mt-2" type="number" v-model="users_telegram" placeholder="edit me" @input="changedrawchart" />-->
       
      
   <!-- <div id="dashboard_div">
    
      <div id="filter_div"></div>
      <div id="chart_div"></div>
    </div>-->

      <h2>Последние запросы</h2>
      <button class="btn btn-success" id="btn">Экспорт Excel</button>
      <div class="table-responsive">
        <table id="Record" class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Кол-во</th>
              <th scope="col">Платформа</th>
              <th scope="col">Запрос</th>
              <th scope="col">Распознан</th>
              <th scope="col">Дата</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>5</td>
              <td>Telegram</td>
              <td>Совместна покупка</td>
              <td>Да</td>
              <td>28.07.23 10:50</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Telegram</td>
              <td>Как сменить пароль?</td>
              <td>Да</td>
              <td>26.07.23 14:50</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Week Seller</td>
              <td>Как выложить товар?</td>
              <td>Да</td>
              <td>27.07.23 16:50</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Telegram</td>
              <td>Что ты не умеешь бот?</td>
              <td>Нет</td>
              <td>24.07.23 06:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Telegram</td>
              <td>test</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Week WEB</td>
              <td>Регистрация</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Week Buyer</td>
              <td>Как присоединиться к совместной покупке?</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Telegram</td>
              <td>Статус заказа</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Telegram</td>
              <td>test</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Week WEB</td>
              <td>Регистрация</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Week Buyer</td>
              <td>Как присоединиться к совместной покупке?</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Telegram</td>
              <td>Статус заказа</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Telegram</td>
              <td>test</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Week WEB</td>
              <td>Регистрация</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Week Buyer</td>
              <td>Как присоединиться к совместной покупке?</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Telegram</td>
              <td>Статус заказа</td>
              <td>Да</td>
              <td>24.07.23 16:50</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
   
          
      
</main>
    