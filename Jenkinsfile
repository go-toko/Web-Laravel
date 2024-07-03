pipeline {
    agent any
    
    environment {
        PROJECT_DIR = '/var/www/html'
    }

    stages {
        // 1. Check if composer and PHP 8.1 are installed
        stage('Check prerequisites') {
            steps {
                script {
                    def composerInstalled = sh(script: 'command -v composer', returnStatus: true) == 0
                    def phpInstalled = sh(script: 'command -v php', returnStatus: true) == 0

                    if (!composerInstalled) {
                        error("Composer is not installed. Please install Composer before proceeding.")
                    }
                    if (!phpInstalled) {
                        error("PHP is not installed. Please install PHP before proceeding.")
                    }
                }
            }
        }

        // 2. Move project to project directory
        stage('Move project to project directory') {
            steps {
                script {
                    sh "sudo cp -r . ${PROJECT_DIR}"
                    sh "sudo chown -R www-data:www-data ${PROJECT_DIR}"
                }
            }
        }

        // 3. Install dependencies
        stage('Install dependencies') {
            steps {
                script {
                    sh "cd ${PROJECT_DIR} && sudo composer install --no-interaction --no-progress --no-suggest"
                }
            }
        }
    }
}
