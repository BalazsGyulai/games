import { createRouter, createWebHistory } from "vue-router";
import Okros from "../views/Okros.vue";
import Dobokockas from "../views/Dobokockas.vue";

const routes = [
  {
    path: "/okros",
    name: "Okros",
    component: Okros,
  },
  {
    path: "/dobokockas",
    name: "Dobokockas",
    component: Dobokockas,
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
