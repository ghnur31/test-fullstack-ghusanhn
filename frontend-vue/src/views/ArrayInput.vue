<template>
  <div class="container mt-5">
    <h2>Input Array of Integers</h2>
    <div class="input-group mb-3">
      <input type="text" v-model="inputArray" class="form-control" placeholder="enter array number, e.g. = 10,20,30">
      <button @click="processInput" class="btn btn-primary">Calculate</button>
    </div>
    
    <div v-if="inputArray && resultArray">
      <h3>Input Array:</h3>
      <p>{{ inputArray }}</p>
      <h3>Result Array:</h3>
      <p>{{ resultArray }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      inputArray: "",
      resultArray: null
    };
  },
  methods: {
    processInput() {
      // Parse inputArray into an array of integers
      let integers = this.parseInputToArray(this.inputArray);

      // Calculate resultArray
      this.resultArray = this.calculateResult(integers);
    },
    parseInputToArray(input) {
      // Remove whitespace and split into array of strings
      let trimmed = input.replace(/\s/g, "");
      let arrayStrings = trimmed.split(",");

      // Convert array of strings to array of integers
      let integers = arrayStrings.map(str => parseInt(str));

      return integers;
    },
    calculateResult(integers) {
      let resultArray = [];

      for (let i = 0; i < integers.length; i++) {
        let sum = 0;
        for (let j = 0; j < integers.length; j++) {
          if (i !== j) {
            sum += integers[j];
          }
        }
        resultArray.push(sum);
      }

      return resultArray;
    }
  }
};
</script>

<style scoped>
/* Add custom styling here */
</style>
