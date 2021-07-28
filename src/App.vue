<template>
  <div>
    <Nav />
  </div>
</template>

<script>
import Nav from './components/Nav.vue'

export default {
  name: "App",
  components: {
    Nav,
  },
  data() {
    return {
      color: '#ff0000',
    };
  },
};
</script>

<style>
* {
  margin: 0;
  padding: 0;
}

body {
  font-family: monospace;
}

#back {
  position: relative;
  margin: 5px;
  width: 40px;
  height: 40px;
}

#back a {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: 0.5s;
}

#back a img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

#links {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  min-width: 150px;
  display: grid;
  grid-template-columns: 100%;
  grid-auto-rows: auto;
}

#links h1 {
  text-align: center;
  font-size: 2.5em;
  margin-bottom: 20px;
}

#links a {
  text-align: center;
  text-decoration: none;
  color: #4d4d4d;
  padding: 10px 5px;
  font-size: 1.5em;
  transition: 0.5s;
}

#links a:hover,
#back a:hover {
  letter-spacing: 1px;
  background: #e4e4e4;
  transition: 0.5s;
}
</style>
