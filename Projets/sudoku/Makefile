CC = gcc
CFLAGS = -c -Wall -ansi -Wextra -std=c99
LDFLAGS = -pthread
TARGET = sudoku
SRC = sudoku.c
OBJ = $(SRC:.c=.o)

.PHONY: all clean run

all: $(TARGET)

$(TARGET): $(OBJ)
	$(CC) $(LDFLAGS) -o $@ $^

%.o: %.c
	$(CC) $(CFLAGS) -o $@ $<

run: $(TARGET)
	./$(TARGET)

clean:
	rm -f $(OBJ) $(TARGET)
