#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <time.h>
#include <pthread.h>

#define TAILLE 9
int grilleSudoku[TAILLE][TAILLE];
int nombresValide;
bool multipleSolutions = false;
pthread_mutex_t mutex;

//initialise une grille en la remplisssant de 0
void init(int grille[TAILLE][TAILLE]) {
    for (int i = 0; i < TAILLE; i++) {
        for (int j = 0; j < TAILLE; j++) {
            grille[i][j] = 0;
        }
    }
}

//clone une grille vers une autre
void copySudoku(int source[TAILLE][TAILLE], int destination[TAILLE][TAILLE]) {
    for (int i = 0; i < TAILLE; i++) {
        for (int j = 0; j < TAILLE; j++) {
            destination[i][j] = source[i][j];
        }
    }
}

//affiche la grille donnee
void displayGrid(int grille[TAILLE][TAILLE]) {
    printf("    ");
    for (int j = 1; j <= TAILLE; j++) {
        printf("%d ", j);
        if (j % 3 == 0) {
            printf("  ");
        }
    }
    printf("\n");

    for (int i = 0; i < TAILLE; i++) {
        if (i % 3 == 0) {
            printf("  +-------+-------+-------+\n");
        }
        printf("%d | ", i + 1);
        for (int j = 0; j < TAILLE; j++) {
            printf("%d ", grille[i][j]);
            if ((j + 1) % 3 == 0) {
                printf("| ");
            }
        }
        printf("\n");
    }
    printf("  +-------+-------+-------+\n");
}

//verifie si on peut placer un nombre donnee a l'emplacement donneee de la grille donnee
bool estValide(int grille[TAILLE][TAILLE], int ligne, int colonne, int nb) {
    for (int i = 0; i < TAILLE; i++) {
        if (grille[ligne][i] == nb) {
            return false;
        }
    }

    for (int i = 0; i < TAILLE; i++) {
        if (grille[i][colonne] == nb) {
            return false;
        }
    }

    int startLigne = ligne - ligne % 3;
    int startColonne = colonne - colonne % 3;
    for (int i = 0; i < 3; i++) {
        for (int j = 0; j < 3; j++) {
            if (grille[i + startLigne][j + startColonne] == nb) {
                return false;
            }
        }
    }

    return true;
}

//fonction recursive qui resoud le sudoku, en partant d'une grille initiale, elle ne peut pas modifier les positions deja remplit
bool resoudreSudokuRecursif(int grille[TAILLE][TAILLE], bool modifiable[TAILLE][TAILLE], int ligne, int colonne) {
    if (ligne == TAILLE - 1 && colonne == TAILLE) {
        return true;
    }

    if (colonne == TAILLE) {
        ligne++;
        colonne = 0;
    }

    if (grille[ligne][colonne] != 0 && !modifiable[ligne][colonne]) {
        return resoudreSudokuRecursif(grille, modifiable, ligne, colonne + 1);
    }

    int nombres[TAILLE] = {1, 2, 3, 4, 5, 6, 7, 8, 9};
    for (int i = 8; i > 0; i--) {
        int j = rand() % (i + 1);
        int temp = nombres[i];
        nombres[i] = nombres[j];
        nombres[j] = temp;
    }
    for (int i = 0; i < TAILLE; i++) {
        int nb = nombres[i];
        if (estValide(grille, ligne, colonne, nb)) {
            grille[ligne][colonne] = nb;
            if (resoudreSudokuRecursif(grille, modifiable, ligne, colonne + 1)) {
                return true;
            }
        }
        grille[ligne][colonne] = 0;
    }
    return false;
}

// fonction permettant de resoudre une grille
bool creerSudokuResolu(int grille[TAILLE][TAILLE]) {
    bool modifiable[TAILLE][TAILLE] = {false};

    // enregistre les cases initialement pleine comme non modifiable
    for (int i = 0; i < TAILLE; i++) {
        for (int j = 0; j < TAILLE; j++) {
            if (grille[i][j] == 0) {
                modifiable[i][j] = true;
            }
        }
    }

    bool result = resoudreSudokuRecursif(grille, modifiable, 0, 0);
    return result;
}

//fonction des threads, verifie si on peut resoudre une grille si un nombre donnee est a une position donnee
void *solveSudokuThread(void *arg) {
    int *donnee = (int *)arg;
    int ligne = donnee[0];
    int colonne = donnee[1];
    int nb = donnee[2];
    free(donnee);

    int grilleCopy[TAILLE][TAILLE];
    copySudoku(grilleSudoku, grilleCopy);
    if(estValide(grilleCopy,ligne,colonne,nb)) {
	    grilleCopy[ligne][colonne] = nb;

	    if (creerSudokuResolu(grilleCopy)) {
		pthread_mutex_lock(&mutex);
		if (multipleSolutions) {
		    pthread_mutex_unlock(&mutex);
		    pthread_exit(NULL);
		}
		multipleSolutions = true;
		pthread_mutex_unlock(&mutex);
	    }
	}
	
    pthread_exit(NULL);
}

//fonction verifiant si, selon la grille actuelle, retirer une position donnee ne mene pas a d'autre solution
bool solutionUnique(int ligne, int colonne, int actu) {
    pthread_t thread_id[8];
    int thread_count = 0;

    multipleSolutions = false;
    pthread_mutex_init(&mutex, NULL);

    for (int i = 1; i <= 9; i++) {
        if (i != actu) {
            int *donnee = malloc(3 * sizeof(int));
            donnee[0] = ligne;
            donnee[1] = colonne;
            donnee[2] = i;
            pthread_create(&thread_id[thread_count], NULL, solveSudokuThread, (void *)donnee);
            thread_count++;
        }
    }

    for (int i = 0; i < thread_count; i++) {
        pthread_join(thread_id[i], NULL);
    }

    pthread_mutex_destroy(&mutex);
    return !multipleSolutions;
}

//fonction essayant de retirer une position sans creer d'autre solution a la grille. si ce n'est pas possible, renvoie true
bool retirerAleatoirement() {
    int ligne, colonne;
    bool impossible = false;
    bool done = false;
    int tentative = 0;

    while (!done) {
        if (tentative >= TAILLE * TAILLE) {
            impossible = true;
            done = true;
        }

        do {
            ligne = rand() % TAILLE;
            colonne = rand() % TAILLE;
        } while (grilleSudoku[ligne][colonne] == 0);
        int old_value = grilleSudoku[ligne][colonne];
        grilleSudoku[ligne][colonne] = 0;
        if (solutionUnique(ligne, colonne,old_value)) {
            nombresValide--;
            done = true;
        } else {
            grilleSudoku[ligne][colonne] = old_value;
        }
        tentative++;
    }
    return impossible;
}

//permete de retirer N nombres sans creer d'autre solution, si ce n'est plus possible, le signal puis s'arrete
void retirerNombres(int N) {
    for (int i = 0; i < N; i++) {
        if(retirerAleatoirement()) {
            printf("Limite atteinte, i = %d \n", i);
            i = N;
        }

    }
}

//verifie que l'utilisateur a bien mit une valeur entre min et max, si non, redemande
int getValidInput(char *msg, int min, int max) {
    int input;
    while (true) {
        printf("%s", msg);
        if (scanf("%d", &input) == 1 && input >= min && input <= max) {
            break;
        } else {
            printf("Entree non valide. Veuillez entrer un nombre entre %d et %d.\n", min, max);
            while (getchar() != '\n');
        }
    }
    return input;
}

//permet a l'utilisateur de choisir une case et de la remplacer par un chiffre de son choix, si possible.
void jouer() {
    int ligne = getValidInput("Choisir la ligne (entre 1 et 9): ", 1, 9) - 1;
    int colonne = getValidInput("Choisir la colonne (entre 1 et 9): ", 1, 9) - 1;

    if (grilleSudoku[ligne][colonne] != 0) {
        printf("ATTENTION: La position (%d, %d) a deja une valeur : %d\n", ligne + 1, colonne + 1, grilleSudoku[ligne][colonne]);
    } else {
        printf("La valeur actuelle a la position (%d, %d) est : %d\n", ligne + 1, colonne + 1, grilleSudoku[ligne][colonne]);
    }

    int nb = getValidInput("Entrez un nombre entre 1 et 9: ", 1, 9);
    if (estValide(grilleSudoku, ligne, colonne, nb)) {
        if (grilleSudoku[ligne][colonne] == 0) {
            nombresValide++;
        }
        grilleSudoku[ligne][colonne] = nb;
    } else {
        printf("%d ne peut pas etre place a la position (%d, %d)\n", nb, ligne + 1, colonne + 1);
    }
}

//verifie si le sudoku est complet
bool estRemplis() {
    return nombresValide == 81;
}

//permet de choisir la difficulte
int difficulte() {
    printf("Facile : 20 chiffres retiree, Moyen : 40 chiffres retiree, Difficile : le plus possible, ici 56 chiffres retiree.");
    int mode = getValidInput("\nDifficulte : Facile = 1, Moyen = 2, Difficile = 3, Custom = 4\n", 1, 4);
    int nb;
    switch (mode) {
        case 1:
            nb = 20;
            break;
        case 2:
            nb = 40;
            break;
        case 3:
            nb = 60;
            break;
        case 4:
            nb = getValidInput("Entrez le nombre de chiffres a retirer (1-81): ", 1, 81);
            break;
    }
    return nb;
}

//ensemble des fonctions preparant le jeu
void start() {
    srand(time(NULL));
    init(grilleSudoku);
    nombresValide = 0;
    creerSudokuResolu(grilleSudoku);
    nombresValide = 81;
    int nbARetirer = difficulte();
    retirerNombres(nbARetirer);
    printf("\nGrille de Sudoku avec %d nombres en moins:\n", nbARetirer);
    displayGrid(grilleSudoku);
}

//demande au joueur de jouer jusqu'a ce que le sudoku soit complet
void play() {
    while (!estRemplis()) {
        jouer();
        printf("\nGrille apres remplacement:\n");
        displayGrid(grilleSudoku);
    }
    printf("Felicitations! Vous avez gagne!\n");
}

int main() {
    start();
    play();
    return 0;
}
