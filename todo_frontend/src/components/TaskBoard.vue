<template>
  <v-row>
    <TaskColumn
        v-for="status in ['To Do', 'In Progress', 'Done']"
        :key="status"
        :title="status"
        :tasks="filteredTasks(status)"
        @add-task="openTaskDialog"
        @edit-task="editTask"
        @view-task-details="viewTaskDetails"
        @update-task-order="updateTaskOrder"
    />
  </v-row>
</template>

<script>
import TaskColumn from './TaskColumn.vue';

export default {
  components: { TaskColumn },
  props: {
    tasks: Array,
  },
  methods: {
    filteredTasks(status) {
      return this.tasks.filter(task => task.status === status);
    },
    openTaskDialog(status) {
      this.$emit('open-dialog', null, status);
    },
    editTask(task) {
      this.$emit('open-dialog', task);
    },
    viewTaskDetails(task) {
      this.$emit('view-task-details', task);
    },
    updateTaskOrder(evt) {
      this.$emit('update-task-order', evt);
    },
  },
};
</script>
