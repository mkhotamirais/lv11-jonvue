<script setup>
import { ref, watch } from "vue";
// import PaginationLinks from "./Components/PaginationLinks.vue";

defineProps({
  users: Object,
});

const search = ref("");

watch(search, (q) => console.log(q));

// format date
const getDate = (date) =>
  new Date(date).toLocaleDateString("en-us", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
</script>

<template>
  <Head :title="$page.component" />

  <!-- <Link class="mt-[1000px] block" href="/" preserve-scroll>Refresh</Link> -->

  <!-- <h1>Home Page</h1> -->

  <div>
    <div class="flex justify-end mb-4">
      <div class="w-1/4">
        <input type="search" placeholder="search" v-mode="search" />
      </div>
    </div>
    <table>
      <thead>
        <tr class="bg-slate-300">
          <th>Avatar</th>
          <th>Name</th>
          <th>Email</th>
          <th>Registration Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users.data" :key="user.id">
          <td>
            <img
              :src="
                user.avatar
                  ? '/storage/' + user.avatar
                  : '/storage/avatars/avatar.png'
              "
              alt=""
              class="avatar"
            />
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ getDate(user.created_at) }}</td>
        </tr>
      </tbody>
    </table>
    <!-- pagination links -->
    <!-- <PaginationLinks :paginator="users" /> -->
  </div>
</template>