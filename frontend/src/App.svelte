<script>
    import { onMount } from 'svelte';
    let todos = [];
    let newTask = '';

    async function loadTodos() {
        const res = await fetch('http://localhost:8082/getTodos.php');
        todos = await res.json();
    }

    async function addTodo() {
        if (!newTask) return;

        await fetch('http://localhost:8082/addTodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ task: newTask })
        });

        newTask = '';
        loadTodos();
    }

    async function deleteTodo(id) {
        await fetch('http://localhost:8082/deleteTodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id })
        });

        loadTodos();
    }

    async function toggleTodo(id) {
        await fetch('http://localhost:8082/toggleTodo.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id })
        });

        loadTodos();
    }

    onMount(loadTodos);
</script>

<main>
    <h1>📝 To-Do List</h1>

    <div class="input-area">
        <input bind:value={newTask} placeholder="할 일 입력" />
        <button on:click={addTodo}>추가</button>
    </div>

    <ul>
        {#each todos as todo}
            <li class:completed={todo.completed == 1}>
                <input type="checkbox" checked={todo.completed == 1} on:change={() => toggleTodo(todo.id)} />
                {todo.task}
                <button on:click={() => deleteTodo(todo.id)}>삭제</button>
            </li>
        {/each}
		 
    </ul>

	<h2>🔎 디버그용 개별 확인</h2>
    {#if todos[0]}
        <p>첫 번째 항목: {todos[0].task} (완료: {todos[0].completed == 1 ? 'O' : 'X'})</p>
    {/if}
    {#if todos[1]}
        <p>두 번째 항목: {todos[1].task} (완료: {todos[1].completed == 1 ? 'O' : 'X'})</p>
    {/if}
</main>

<style>
    main {
        text-align: center;
        padding: 2rem;
        max-width: 600px;
        margin: 0 auto;
    }

    h1 {
        color: #ff3e00;
        text-transform: uppercase;
        font-size: 3rem;
        margin-bottom: 2rem;
    }

    .input-area {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    input[type="text"] {
        width: 60%;
        padding: 0.5rem;
        font-size: 1rem;
    }

    button {
        padding: 0.5rem 1rem;
        background: #ff3e00;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.5rem;
        border-bottom: 1px solid #ddd;
    }

    li.completed {
        text-decoration: line-through;
        color: #999;
    }

    li button {
        background: #ccc;
        color: #333;
        border: none;
        padding: 0.3rem 0.7rem;
        border-radius: 3px;
        cursor: pointer;
    }
</style>
