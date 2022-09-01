<template>
  <section class="container">
    <div class="row py-5 gy-3">

      <div class="offset-lg-3 offset-sm-1 col-lg-6 col-sm-10 col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">
              Hello
            </h4>
            <p>
              На данном проекте Мы будем рассматривать работу Redis
              <br>
              Прежде всего, мы рассмотрим такие вещи как обмен данными
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <div class="card-body">
            <p>
              Данная кнопка сохраняет данные (кеширует) непосредственно в
              Redis
            </p>
            <p>
              Что бы сохранить данные, введите их в поле и нажмите отправить.
              После успешного сохранения, эти данные появятся ниже
            </p>

            <div class="row">
              <div class="col-auto">
                <input
                  type="text"
                  v-model="putRedis"
                  placeholder="Введите данные"
                  class="form-control"
                >
              </div>
              <div class="col">
                <button
                  class="btn btn-primary"
                  @click="sendDataForPutRedis"
                >Сохранить
                </button>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                Данные с Redis: {{ putRedis }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <input type="email" class="form-control" placeholder="Email" v-model="email">
              </div>
              <div class="col">
                <button class="btn btn-dark" @click="sendEmail">Добавить в очередь </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <p>В данном блоке мы используем сервер вебсокета для реактивного принятия данных от сервера</p>
                <pre>php artisan websocket:serve</pre>
                <pre>php artisan queue:work</pre>
                <button class="btn btn-primary" @click="createEventSendMessage">Создать Event</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
          <div class="card-body">
            <div class="row gy-2">
              <div class="col-12 bg-light">
                <div class="row" v-for="message in messages">
                  <div class="col-12 my-2">Гость: {{ message }}</div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-8">
                    <input type="text" class="form-control" v-model="inputMessage" placeholder="Введите текст...">
                  </div>
                  <div class="col">
                    <button class="btn btn-dark" @click="sendMessage">Отправить</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script>
export default {
  name: "Index",
  data: () => ({
    putRedis: null,
    email: null,
    messages: [],
    inputMessage: null,
    disabledStatusSendButton: false
  }),
  mounted() {
    this.getDataForPutRedis()

    Echo.channel('chat')
      .listen('SendMessageEvent', (e) => {
        alert('Сообщение с рандобным словом от сервера: ' + e.message)
      })
      .listen('NewMessageInChatEvent', (data) => {
        this.messages.push(data.message)
      })

  },
  methods: {
    async sendMessage () {
      this.disabledStatusSendButton = true
      await axios.post('api/new-message', {
        message: this.inputMessage
      })
        .then(r => {
          this.inputMessage = null
          this.disabledStatusSendButton = false
        })
    },
    sendDataForPutRedis() {
      axios.put('api/redis-put', {
        message: this.putRedis
      })
        .then(() => {
          this.getDataForPutRedis()
        })
    },
    async getDataForPutRedis() {
      await axios.get('api/redis-get')
        .then(r => {
          this.putRedis = r.data.message
        })
    },
    async sendEmail () {
      await axios.post('api/create-job', {
        email: this.email
      })
        .then(r => {
          alert(r.data.message)
          this.email = null;
        })
    },
    async createEventSendMessage () {
      await axios.post('api/creat-test-message')
        .then(r => {
          console.log(r.data)
        })
    }
  }
}
</script>

<style scoped>

</style>