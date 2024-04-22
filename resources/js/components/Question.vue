<template>
  <div class="card shadow mb-4 overflow-hidden" ondragstart="return false" onselectstart="return false" >
    <div class="card-body animate__animated animate__bounceInUp">
      <div class="fs-5 mb-4" v-text="questionText"/>
      
      <div class="mb-4">
        <div v-if="answersIsLoading">
          <button
            v-for="i in 5"
            :key="i"
            class="d-flex align-items-center btn-outline-dark shadow btn p-3 mb-3 w-100 text-start"
            disabled
          >
            <div class="me-3"><i class="fal fa-fw fa-cog fa-spin"></i></div>
            <div>Cargando...</div>
          </button>
        </div>

        <button
          v-else
          v-for="{ id, text } in answers"
          class="d-flex align-items-center btn p-3 mb-3 w-100 text-start"
          :class="
            selectedAnswer == id  ? 'btn-success' : 'btn-outline-dark shadow'
          "
          :disabled="resultIsLoading"
          :key="id"
          type="button"
          @click.prevent="setSelectedAnswer(id)"
        >
          <div class="me-3">
            <i
              class="fal fa-fw"
              :class="selectedAnswer == id ? 'fa-check-square' : 'fa-square'"
            />
          </div>
          <div v-text="text" />
        </button>
      </div>

      <div class="w-100">
        <button class="btn btn-lg btn-primary" disabled v-if="resultIsLoading">
          <i class="fal fa-fw fa-cog fa-spin me-2"></i>Confirmando respuesta...
        </button>

        <button
          v-else
          class="btn btn-lg btn-primary"
          :disabled="!selectedAnswer"
          type="button"
          @click.prevent="submitAnswer"
        >
          Confirmar respuesta
        </button>

        <button
          class="btn btn-lg btn-danger float-end "

          type="button"
          @click.prevent="nextAnswer"
        >
          Saltar Pregunta
        </button>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Question",


  data: () => ({
    answers: [],
    answersIsLoading: true,
    resultIsLoading: false,
    selectedAnswer: null,
  }),

  mounted() {

          this.selectedAnswer = this.answer;
        //   console.log(this.selectedAnswer)

    axios
      .get(`/api/exam/${this.exam}/${this.question}/answers`)
      .then(({ data }) => {
        console.log(this.selectedAnswer)
        this.answers = data;
        this.answersIsLoading = false;
      })
      .catch((error) => console.error(error));
  },

  methods: {
    setSelectedAnswer(id) {
      this.selectedAnswer = id;
    },

    submitAnswer() {
      this.resultIsLoading = true;

      axios
        .get(`/api/exam/${this.exam}/${this.question}/${this.selectedAnswer}`)
        .then(() => {
          window.location.href = this.nextQuestionUrl;
        })
        .catch((error) => console.error(error));
    },

    nextAnswer(){
        window.location.href = this.nextQuestionUrl;
    }
  },

  props: {
    exam: {
      required: true,
      type: String,
    },
    nextQuestionUrl: {
      required: true,
      type: String,
    },
    question: {
      required: true,
      type: Number,
    },
    questionText: {
      required: true,
      type: String,
    },
    answer: {
    //   required: true,
      type: Number,
    },
  },
};
</script>
