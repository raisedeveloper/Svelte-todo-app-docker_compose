<script>
    import { onMount } from 'svelte';

    let todos = [];
    let newTask = '';

    // 할 일 목록 불러오기
    async function loadTodos() {
        const res = await fetch('http://localhost/todo-backend/api/getTodos.php');
        todos = await res.json();
    }

    // 할 일 추가하기
    async function addTodo() {
        if (!newTask) return;

        await fetch('http://localhost/todo-backend/api/addTodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ task: newTask })
        });

        newTask = '';
        loadTodos();
    }

    // 할 일 삭제하기
    async function deleteTodo(id) {
        await fetch('http://localhost/todo-backend/api/deleteTodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id })
        });

        loadTodos();
    }

    // 할 일 완료 여부 토글하기
    async function toggleTodo(id) {
        await fetch('http://localhost/todo-backend/api/toggleTodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id })
        });

        loadTodos();
    }

    // 페이지 로딩 시 실행
    onMount(loadTodos);
</script>

<h1>📝 To-Do List</h1>

<div>
    <input bind:value={newTask} placeholder="할 일 입력" />
    <button on:click={addTodo}>추가</button>
</div>

<ul>
    {#each todos as todo}
        <li>
            <input type="checkbox" checked={todo.completed} on:change={() => toggleTodo(todo.id)} />
            {todo.task}
            <button on:click={() => deleteTodo(todo.id)}>삭제</button>
        </li>
    {/each}
</ul>
