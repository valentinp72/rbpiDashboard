LIB = -lwiringPi

all: emit

emit: emit.o
	gcc $^ -o $@ $(LIB)

emit.o: emit.c
	gcc -c $^ -o $@ $(LIB)


clean:
	rm *.o
	rm emit

clear: clean
