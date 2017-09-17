CXXFLAGS=-DRPI -Wno-write-strings
LIB = -lwiringPi

all: emit 
	cp buttonsServer.service /etc/systemd/system/buttonsServer.service

emit.o: emit.c
	g++ $(CXXFLAGS) -c $^ -o $@ $(LIB)

emit: RCSwitch.o emit.o
	g++ $(CXXFLAGS) $^ -o $@ -lwiringPi


clean:
	rm *.o
	rm emit

clear: clean
