pipeline {
    agent any

    stages {
        stage('Git Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/raisedeveloper/Svelte-todo-app-docker_compose'
            }
        }

        stage('Docker Compose Down') {
            steps {
                sh 'docker-compose down || true'
            }
        }

        stage('Docker Compose Build') {
            steps {
                sh 'docker-compose build'
            }
        }

        stage('Docker Compose Up') {
            steps {
                sh 'docker-compose up -d'
            }
        }
    }

    post {
        success {
            echo '✅ Deployment Success!'
        }
        failure {
            echo '❌ Deployment Failed...'
        }
    }
}
