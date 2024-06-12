<template>
  <v-col>
    <v-card>
      <v-card-title>{{ title }}</v-card-title>
      <v-card-text>
        <v-container :data-status="title">
          <draggable
              :list="tasks"
              @end="onDragEnd"
              item-key="id"
              group="tasks"
          >
            <template #item="{ element }">
              <TaskCard :task="element" @edit="editTask" @view="viewTaskDetails"/>
            </template>
          </draggable>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-btn @click="addTask">Add Task</v-btn>
      </v-card-actions>
    </v-card>
  </v-col>
</template>

<script>
import draggable from 'vuedraggable';
import TaskCard from './TaskCard.vue';

export default {
  components: { TaskCard, draggable },
  props: {
    title: String,
    tasks: Array,
  },
  methods: {
    addTask() {
      this.$emit('add-task', this.title);
    },
    editTask(task) {
      this.$emit('edit-task', task);
    },
    viewTaskDetails(task) {
      this.$emit('view-task-details', task);
    },
    onDragEnd(evt) {
      this.$emit('update-task-order', { ...evt, status: this.title });
    },
  },
};
</script>
