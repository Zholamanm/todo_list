<template>
  <v-card class="mb-2" @click="viewDetails">
    <v-card-title>{{ task.title }}</v-card-title>
    <v-card-subtitle>{{ task.priority }}</v-card-subtitle>
    <v-card-actions>
      <v-btn icon @click.stop="editTask">
        <v-icon>mdi-pencil</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  props: {
    task: Object,
  },
  methods: {
    viewDetails() {
      this.$emit('view', this.task);
    },
    editTask() {
      this.$emit('edit', this.task);
    },
  },
};
</script>
