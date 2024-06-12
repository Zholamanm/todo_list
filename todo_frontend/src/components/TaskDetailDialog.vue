<template>
  <v-dialog v-model="internalVisible" max-width="500">
    <v-card v-if="task">
      <v-card-title>{{ task.title }}</v-card-title>
      <v-card-text>
        <p><strong>Description:</strong> {{ task.description }}</p>
        <p><strong>Status:</strong> {{ task.status }}</p>
        <p><strong>Priority:</strong> {{ task.priority }}</p>
        <p><strong>Created At:</strong> {{ task.created_at }}</p>
        <p><strong>Updated At:</strong> {{ task.updated_at }}</p>
      </v-card-text>
      <v-card-actions>
        <v-btn color="red" @click="deleteTask">Delete</v-btn>
        <v-btn @click="close">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    task: Object,
    visible: Boolean,
  },
  data() {
    return {
      internalVisible: this.visible,
    };
  },
  watch: {
    visible(newValue) {
      this.internalVisible = newValue;
    },
  },
  methods: {
    close() {
      this.internalVisible = false;
      this.$emit('update:visible', false);
      this.$emit('close');
    },
    deleteTask() {
      if (this.task && this.task.id) {
        this.$emit('delete', this.task.id);
        this.close();
      }
    },
  },
};
</script>
