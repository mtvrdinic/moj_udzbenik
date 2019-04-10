#include <bits/stdc++.h>
#include <iostream> 

using namespace std;




bool CheckWord(char* filename, char* search){

  int offset; 
  string line;
  ifstream Myfile;
  Myfile.open (filename);

  if(Myfile.is_open()){

      while(!Myfile.eof()){

          getline(Myfile,line);
          if ((offset = line.find(search, 0)) != string::npos){
           return true;
          }  

      }

      Myfile.close();
      
  }  

  return false;
}

int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  //int counter = 1;
  int counter = 886;
  
  for(int i = 0; i < 412; i++){
  	cin.std::istream::getline (s, 1000);

    if(!CheckWord("skole_koje_se_ponavljaju.txt", s)){      
      cout << counter << ';';
      cout << s << endl;

      counter++;
    }

  }

  return 0;
}