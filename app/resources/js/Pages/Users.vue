<script setup>
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import { Table } from "@reyptr27/laravel-inertia-table";

// use this one for development:
// import Table from "../../../../js/Components/Table.vue"

defineProps(["users"]);
</script>

<template>
  <BreezeGuestLayout>
    <Table
      :resource="users"
      :input-debounce-ms="50"
    >
      <template #cell(actions)="{ item: user }">
        <a
          :href="`/users/${user.id}/edit`"
        >
          Edit
        </a>
      </template>
    </Table>
  </BreezeGuestLayout>
</template>
