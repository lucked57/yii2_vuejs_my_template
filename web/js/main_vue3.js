
var edittexglobal;

function getCookie(name) {
  let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function setCookie(name, value, options = {}) {

  options = {
    path: '/',
    // при необходимости добавьте другие значения по умолчанию
    ...options
  };

  if (options.expires instanceof Date) {
    options.expires = options.expires.toUTCString();
  }

  let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

  for (let optionKey in options) {
    updatedCookie += "; " + optionKey;
    let optionValue = options[optionKey];
    if (optionValue !== true) {
      updatedCookie += "=" + optionValue;
    }
  }

  document.cookie = updatedCookie;
}

function deleteCookie(name) {
  setCookie(name, "", {
    'max-age': -1
  })
}


function validateEmail(email) {
    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(String(email).toLowerCase());
  }

 
google.charts.load('current', {'packages':['corechart', 'controls']});




const EventHandling = {
  data() {
    return {
      error: false,
      flag:"",
      id:0,
      edittext:"",
      load:false,
      title:"",
      text:"",
      flag: false,
      email: "",
      subject: "",
      text: "",
      name: "",
      file:"",
      errorshow: [],
      email:'',
      password:'',
      isDisabled:false,
      emailBlured : false,
      valid : false,
      submitted : false,
      passwordBlured:false,
      passwordchangeBlured:false,
      passwordchangeagainBlured:false,
      passwordchange:"",
      passwordchangeagain:"",
      username:"",
      usernameBlured:false,
      phone:"",
      phoneBlured:false,
      email_error:'Не валидный email',
      password_error:'Минимум 8 символов и 1 заглавная буква',
      users_telegram:40,
      users_week_seller:15,
      users_week_buyer:10,
      users_week_web:14,
    }
  },
  methods: {
    validate : function(){
this.emailBlured = true;
this.passwordBlured = true;
this.usernameBlured = true;
this.phoneBlured = true;
if( this.validEmail(this.email) && this.validPassword(this.password)){
this.valid = true;
}
else{
  this.valid = false;
}
},
validatepass : function(){
this.emailBlured = true;
this.passwordBlured = true;
this.usernameBlured = true;
this.phoneBlured = true;
this.passwordchangeBlured = true;
this.passwordchangeagainBlured = true;
if( this.validPassword(this.password) && this.validPassword(this.passwordchange) && this.validPassword(this.passwordchangeagain)){

  if(this.passwordchange.localeCompare(this.passwordchangeagain) == 0){

    if(this.password.localeCompare(this.passwordchange) == 0){
      this.valid = false;
      this.error = true;
      this.password_error = "Новый и старый пароль не должны совпадать";
    }
    else{
      this.valid = true;
      this.error = false;
    }

    
  }
  else{
    this.valid = false;
    this.error = true;
    this.password_error = "Новый и повторной новый пароль не совпадают";
  }
  

}
else{
  this.valid = false;
  this.error = false;
}
},

validEmail : function(email) {
  if(!this.error){
    this.email_error = "Не валидный email";
  }
  
var re = /(.+)@(.+){2,}\.(.+){2,}/;
if(re.test(email.toLowerCase())){
  return true;
  }
},

validPassword : function(password) {
  if(!this.error){
    this.password_error = "Минимум 8 символов и 1 заглавная буква";
  }
   if (password.length > 7 && password !== password.toLowerCase()) {
    return true;
   }
},

submitsignin : function(){
  this.error = false;
this.validate();
if(this.valid){

      this.isDisabled = true;
              var param = {
                    target: 'signin',
                    email: this.email,
                    password: this.password,
            };
            const str = JSON.stringify(param);
            axios.post('/site/login', str)
                .then(response => {
                  this.isDisabled = false;
                    console.log(response.data); 
                    if(response.data == "Данные приняты"){
                      window.location = '/';
                    }
                })

                .catch(error => {
                  this.isDisabled = false;
                    console.log(error);
                    console.log(error.response.data.message);
                    this.error = error.response.data.message;
                    this.email_error = error.response.data.message;
                    this.password_error = error.response.data.message;
                });
}
},
changepass : function(){
  this.error = false;
this.validatepass();
if(this.valid){
  //console.log('work');
            this.isDisabled = true;
              var param = {
                    target: 'changepass',
                    password: this.password,
                    password_new: this.passwordchange,
            };
            const str = JSON.stringify(param);
            axios.post('/site/login', str)
                .then(response => {
                  this.isDisabled = false;
                    console.log(response.data); 
                    alert(response.data);
                    
                })

                .catch(error => {
                  this.isDisabled = false;
                    console.log(error);
                    console.log(error.response.data.message);
                    this.error = error.response.data.message;
                    this.password_error = error.response.data.message;
                });
      
}
},
    //Изменение текста в БД
     editaxios: function (event) {
      document.querySelector('#save').disabled = true;
      document.querySelector('#close').disabled = true;
          var param = {
                    target: 'change',
                    id: this.id,
                    edittext: this.edittext,
            };
            const str = JSON.stringify(param);
            axios.post('/site/index', str)
                .then(function(response) {
                    alert(response.data); 
                    document.querySelector('#save').disabled = false;
                    document.querySelector('#close').disabled = false;   
                })
                .catch(function (error) {
                    console.log(error);
                    document.querySelector('#save').disabled = false;
                    document.querySelector('#close').disabled = false;
                });

    
  },
  validemail: function(email){
    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
        return re.test(String(email).toLowerCase());
    },
  signinaxios: function(){
    console.log('work');
            this.error = false;
            this.errorshowo = {};
            if(typeof this.email == "undefined"){
                  this.errorshowo.email = 'Пожалуйста заполните поле';
               }
               else if(!this.validemail(this.email)){
                this.errorshowo.email = 'Пожалуйста укажите корректный email';
              }
              if(typeof this.password == "undefined"){
                this.errorshowo.password = 'Пожалуйста заполните поле';
              }
              else if(this.password.trim().length == 0){
                this.errorshowo.password = 'Пожалуйста заполните поле';
              }
              console.log(this.email);
              console.log(this.password);

            if(Object.keys(this.errorshowo).length === 0 ){
              this.isDisabled = true;
              var param = {
                    target: 'signin',
                    email: this.email,
                    password: this.password,
            };
            const str = JSON.stringify(param);
            axios.post('/site/login', str)
                .then(response => {
                  this.isDisabled = false;
                    console.log(response.data); 
                })

                .catch(error => {
                  this.isDisabled = false;
                    console.log(error);
                });

            }
  },
  signin: function(){
              var bodyFormData = new URLSearchParams({
            'username': 'b@b.b',
            'password': '123',
             });
              axios({
              method: "post",
              url: "https://week-app-api-dev.ru/webold/auth/sign-in", 
              data: bodyFormData,
              headers: { "Content-Type": "application/x-www-form-urlencoded", 'accept': 'application/json'},
            })
              .then(response => {
               
                
                    console.log(response.data);
                    var access_token = response.data.access_token;
                    var refresh_token = response.data.refresh_token;
                    var token_type = response.data.token_type;
                    var user_type = response.data.user_type;
                })

                .catch(error => {
                  //this.isDisabled = false;
                    console.log(error);
                    //this.errorshowo.password = 'Указан неверный логин или пароль';
                    //this.errorshowo.email = 'Указан неверный логин или пароль';
                    //typeof this.password == "undefined"

                    if (!error.response.data) {
                        //this.errorshowo.email = 'Error: Network Error' + error;
                        //this.errorshowo.password = 'Error: Network Error' + error;

                      }
                      else{
                        //this.errorshowo.password = 'Указан неверный логин или пароль';
                        //this.errorshowo.email = 'Указан неверный логин или пароль';
                      }
                });
            
      },
  //Вывод данные для input
  selecteditaxios: function () {
    document.querySelector('#save').disabled = true;
    document.querySelector('#close').disabled = true;
          var param = {
                    target: 'select',
                    id: this.id,
                    edittext: 'select',
            };
            //console.log(this.id);
            const str = JSON.stringify(param);
            axios.post('/site/index', str)
    .then(response => {
            //console.clear();
            this.edittext = response.data;
            console.log(this.edittext);
            document.querySelector('#save').disabled = false;
            document.querySelector('#close').disabled = false;
          })
          .catch(error => {
            console.log(error);
            document.querySelector('#save').disabled = false;
            document.querySelector('#close').disabled = false;
          });

  },
  //Загрузка поста
  uploadpost: function () {
    document.querySelector('#send_file').disabled = true;
    this.load = true;
    var formData = new FormData();
    var imagefile = document.querySelector('#file');
    formData.append("image", imagefile.files[0]);
    formData.append("title", this.title);
    formData.append("text", this.text);
    var error = false;
    if(!imagefile.files[0]){
      error = "Загрузите изображение";
    }
    if(this.title.length == 0){
      error = "Название пустое";
    }
    if(this.text.length == 0){
      error = "Описание пустое";
    }
    if(!error){
    axios.post('/site/addpost', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
    })
    .then(response => {
            alert(response.data);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          })
          .catch(error => {
            alert(error);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          });

          }
          else{
            alert(error);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          }
  },
  //load photo
  uploadphoto: function () {
    document.querySelector('#send_file').disabled = true;
    this.load = true;
    var formData = new FormData();
    var imagefile = document.querySelector('#file');
    formData.append("image", imagefile.files[0]);
    var error = false;
    if(!imagefile.files[0]){
      error = "Загрузите изображение";
    }
    if(!error){
    axios.post('/site/addphoto', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
    })
    .then(response => {
            alert(response.data);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          })
          .catch(error => {
            alert(error);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          });

          }
          else{
            alert(error);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          }
  },
  Sendemail() {
      
      console.log(email);
      var error = false;

      if (!validateEmail(this.email)){
        error = 'Некорректное значения email';
      }
      if(this.email == '' || this.name == '' || this.text == '' || this.subject == ''){
        error = 'Есть пустые значения';
      }

      if(this.flag){
        error = 'Данные уже были отправлены';
      }

      if(!error){
        document.querySelector('#send_file').disabled = true;
        this.load = true;
        this.flag = true;

        var bodyFormData = JSON.stringify({ 'email': this.email,'name': this.name,'text': this.text,'subject': this.subject });
              axios({
              method: "post",
              url: "/web/sendemail.php", 
              data: bodyFormData,
              headers: { "Content-Type": "application/json" },
            })
              .then(response => {
            //alert(response.data);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
            if(response.data == '1' || response.data == 1){
                  alert('Данные успешно отправлены');
                }
                else{
                  alert(response.data);
                }
          })
          .catch(error => {
            alert(error);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          });
      }
      else{
        alert(error);
      }
      //console.log(this.comment);
    },
    Sendemailfile() {
      
      console.log(email);
      var error = false;
      console.log(this.file);

      if(!this.file){
        error = 'Пожалуйста загрузите файл';
      }
      if (!validateEmail(this.email)){
        error = 'Некорректное значения email';
      }
      if(this.email == '' || this.name == '' || this.text == '' || this.subject == ''){
        error = 'Есть пустые значения';
      }
      

      if(this.flag){
        error = 'Данные уже были отправлены';
      }

      if(!error){
        document.querySelector('#send_file').disabled = true;
        this.load = true;
        this.flag = true;

        var bodyFormData = new FormData();
          bodyFormData.append('doc_file', this.file);
          bodyFormData.append('email', this.email);
          bodyFormData.append('subject', this.subject); // 1 - без привязки к товару
          bodyFormData.append('text', this.text);
          bodyFormData.append('name', this.name);
              axios({
              method: "post",
              url: "/web/sendemailfile.php", 
              data: bodyFormData,
              headers: { "Content-Type": "multipart/form-data" },
            })
              .then(response => {
            //alert(response.data);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
            if(response.data == '1' || response.data == 1){
                  alert('Данные успешно отправлены');
                }
                else{
                  alert(response.data);
                }
          })
          .catch(error => {
            alert(error);
            document.querySelector('#send_file').disabled = false;
            this.load = false;
          });
      }
      else{
        alert(error);
      }
      //console.log(this.comment);
    },
    handleFileUpload: function(){
    this.file = this.$refs.file.files[0];
  },
  onFileChange(e) {
      this.file = e.target.files || e.dataTransfer.files;
      /*if (!files.length)
        return;
      this.createImage(files[0]);*/
    },
    drawChart: function () {
      var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Telegram - ' + this.users_telegram,     this.users_telegram],
          ['Week Seller - ' + this.users_week_seller,      this.users_week_seller],
          ['Week Buyer - ' + this.users_week_buyer,  this.users_week_buyer],
          ['Week WEB - ' + this.users_week_web, this.users_week_web],
        ]);

        var options = {
          title: 'Week - кол-во пользователей'
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    },
    changedrawchart:function(){
      google.charts.setOnLoadCallback(() => this.drawChart());
    }
  },
    mounted(){
      console.log(Vue.version);
      //this.signin();
      if(document.querySelector("#piechart")){
        this.changedrawchart();
      }
      
    
  }
}

Vue.createApp(EventHandling).mount('#app');

//google.charts.load('current', {'packages':['corechart']});
      

      /*function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Telegram (40)',     40],
          ['Week Seller (15)',      15],
          ['Week Buyer (10)',  10],
          ['Week WEB (14)', 14],
        ]);

        var options = {
          title: 'Week - кол-во пользователей'
        };
      
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
        
      }
      google.charts.setOnLoadCallback(drawChart);*/



// Load the Visualization API and the controls package.
      

      // Set a callback to run when the Google Visualization API is loaded.
      if(document.querySelector('#dashboard_div')){
        google.charts.setOnLoadCallback(drawDashboard);
      }
      

      // Callback that creates and populates a data table,
      // instantiates a dashboard, a range slider and a pie chart,
      // passes in the data and draws it.
      function drawDashboard() {

        // Create our data table.
        var data = google.visualization.arrayToDataTable([
          ['Name', 'Кол-во пользователей'],
          ['Telegram (40)',     40],
          ['Week Seller (15)',      15],
          ['Week Buyer (10)',  10],
          ['Week WEB (14)', 14],
        ]);

        // Create a dashboard.
        var dashboard = new google.visualization.Dashboard(
            document.getElementById('dashboard_div'));

        // Create a range slider, passing some options
        var donutRangeSlider = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'filter_div',
          'options': {
            'filterColumnLabel': 'Кол-во пользователей'
          }
        });

        // Create a pie chart, passing some options
        var pieChart = new google.visualization.ChartWrapper({
          'chartType': 'PieChart',
          'containerId': 'chart_div',
          'options': {
            'width': '100%',
            'height': 500,
            'pieSliceText': 'value',
            'legend': 'right'
          }
        });

        // Establish dependencies, declaring that 'filter' drives 'pieChart',
        // so that the pie chart will only display entries that are let through
        // given the chosen slider range.
        dashboard.bind(donutRangeSlider, pieChart);

        // Draw the dashboard.
        dashboard.draw(data);
      }

    if(document.querySelector("#btn")){
document.getElementById("btn").addEventListener("click", () => {
  let table2excel = new Table2Excel();
  table2excel.export(document.querySelector("#Record"));
});
}



 





