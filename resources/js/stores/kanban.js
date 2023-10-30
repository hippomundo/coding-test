import { defineStore } from 'pinia'

export const useKanbanStore = defineStore('kanban', {
  state: () => {
    return {
        hoveredName: 'nothing',
        selectedTask: null,
        phases: [],
        users: [],
        creatingTask: false,
        movingTask:false,
        editingTask: false,
        creatingTaskProps: {
          name: '',
          phase_id: null,
          user_id: null,
        },
        editingTaskProps: {
            name: '',
            phase_id: null,
            user_id: null,
        },
        movingTaskModal: {
            name:'',            
            phase_id: null,            
          },
        self: null,
    }
  },
  actions: {
    unhoverTask() {
      this.hoveredName = 'nothing'
    },
    selectTask(task) {
        this.selectedTask = task
    },
    unselectTask(task) {
        this.selectedTask = null
    },
    unselectEditableTask() {
        this.editingTask = false;
        this.editingTaskProps = {
            name: '',
            phase_id: null,
            user_id: null,
        }
    },
    hasSelectedTask() {
        return this.selectedTask !== null
    },

      async updateTask() {
          try {
              const response = await axios.put('/api/tasks/'+this.editingTaskProps.id, this.editingTaskProps);
              this.editingTask = false;
              this.editingTaskProps = {
                  name: null,
                  phase_id: null,
                  user_id: null
              };
              await this.refreshTasks();

              return {res: 1, error: null}
          } catch (error) {
              if (error.response.status === 422) {
                  // errors.value = error.response.data.errors;
                  return {res: null, error: error.response.data.errors, status: error.response.status}
              }
              else{
                  console.error(error.response.message)
              }
          }
      },

      async deleteTask(id) {
          try {
              const response = await axios.delete('/api/tasks/' + id);
              await this.refreshTasks();
              this.unselectTask();
          } catch (error) {
              console.error('There was an error deleting the task!', error);
          }
      },

    
      async moveCard(id, phase) {
        try {
            const response = await axios.post('/api/phases', {
                type: All,
                phase_id: null,   
            });

        } catch (error) {
            console.error('There was an error fetching the tasks!', error);
        }
    },

      async deletePhase(id){
          try {
              const response = await axios.delete('/api/phases/'+id);
              await this.refreshTasks();

          } catch (error) {
              console.error('There was an error fetching the tasks!', error);
          }
      },

    async refreshTasks() {
      try {
          const response = await axios.get('/api/tasks');
          const originalTasks = response.data;
          this.phases = originalTasks.reduce((acc, cur) => {
              acc[cur.id] = cur;
              return acc;
          }, {});
      } catch (error) {
          console.error('There was an error fetching the tasks!', error);
      }
    }
  },
})
